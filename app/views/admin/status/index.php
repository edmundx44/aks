<?php $this->setSiteTitle("Status Controller"); ?>
<?php $this->start('head'); ?>
	<link rel="stylesheet" href="<?=PROOT?>vendors/css/links-page.css" media="screen" title="no title" charset="utf-8">
	<script>
		
		var $from = null;
		var $website = null;
		$(function() {

			setActiveTab(getUrlParameter('tab'));
				
			$(document).on('click', '.sc-li-btn', function(){
				$('.sc-li-btn').removeClass('active-sc-menu');
				$('#'+$(this).attr('id')).addClass('active-sc-menu');
				$('.sc-content-div').hide();
				$('.'+$(this).attr('id')).show();

				$('.append-merchants').empty(); //empty all
				$('.append-critics').empty(); //empty all
				switch($(this).attr('id')){
					case 'sc-merchant-div':
						var param = '';
						$('.div-site-hide').show();
						AjaxStores();
					break;
					case 'sc-metacritics-div':
						var param = '?tab=metacritics';
						$('.div-site-hide').hide();
						AjaxCritics();
					break;
				}
				var newurl = window.location.protocol + "//" + window.location.host + window.location.pathname + param;
				window.history.pushState({ path: newurl }, '', newurl);
			});

			$(document).on('click', '.website-items', function(){
				$('#website-btn').val($(this).attr('data-website').toUpperCase())
				$('.selected-data').attr('data-selected-site', $(this).attr('data-website'))
				var indexInput = $(this).parent().prevObject.index(); //get the index of li
				if($(this).parent()[0].children.length == 3 ){
					var site = (indexInput == 0 ) ? inputsSite[0].site : (indexInput == 1 ) ? inputsSite[1].site : (indexInput == 2 ) ? inputsSite[2].site : '';
					let $_query = { action : "get-stores-status", site : site }
					setStorage('sessionStorage','website',JSON.stringify($_query.site))
					AjaxStores($_query)
				}else
					removedKeyNormal('sessionStorage','website') 
			});

			$(document).on('click', '.btn-status', function (){
				var $id = $(this).closest('.div-merchant').attr('data-id');
				var $status = $(this).val();
				let $_query = null;
				if( ['ON','OFF'].includes($status) && $id !== '' && typeof $id !== 'undefined'){

					$note = ($status === "ON") ? 'DISABLED' : 'ENABLED' ;
					$modalContent = {
						header: '<div id="confimation-header-style">Are you sure?</div>',
						body  : '<div id="confimation-body-style">Do you really want to '+$note+' this merchant '+ $id +'</div>',
						footer: '<input id="modal-confirmation" class="col-6 button-on" style="margin:0 auto; border-radius:5px;" type="button" value="YES">'
					}
					confirmDialog($modalContent,function(e){
						$_query = getUpdateQuery($id, $status);
						if($_query !== undefined){
							$(this).val("Loading");
							$('.btn-status').attr("disabled","disabled")
							AjaxUpdateStatus($_query);
						}
					})

				}else
					alertMsg("Invalid Status Please reload the page")	
			});
		}); // end document ready function
		
		function confirmDialog($con, onConfirm){
			var fClose = function(){
				modal.modal("hide");
			};
			var modal = $("#report-modal-confirmation");
			modal.modal('show');
			$('.confirmation-tittle').empty().html($con.header);
			$('.modal-content-body').empty().append($con.body);
			$('.confirmation-modal-footer').empty().append($con.footer);	
			$("#modal-confirmation").unbind().one('click', onConfirm).one('click', fClose);
		}

		function setActiveTab($param){
			$('.sc-li-btn').removeClass('active-sc-menu');
			$('.sc-content-div').hide();
			switch($param){
				case 'metacritics':
					$('.div-site-hide').hide();
					var divClassID = 'sc-metacritics-div';
					AjaxCritics();
				break;
				default:
					$('.div-site-hide').show();
					var divClassID = 'sc-merchant-div';
					var site = safelyParseJSON(getStorage('sessionStorage','website'));
					var $_query = { action : "get-stores-status", site : site }
					if( site && returnSite(site) != null){
						$('#website-btn').val(site.toUpperCase())
						AjaxStores($_query);
					}else{ removedKeyNormal('sessionStorage','website') 
						$_query.site = 'aks';
						AjaxStores($_query);
					}
				break;
			}

			$('.'+divClassID).show();
			$('#'+divClassID).addClass('active-sc-menu');
		}

		function AjaxStores($_query = false){
			if(!$_query)		
				var $_query = { action : "get-stores-status" , site : 'aks'}
			AjaxCall(url, $_query).done(storeList)
			$website = $_query.site;
			$('#website-btn').val($_query.site.toUpperCase())
		}

		function AjaxCritics($_query = false){	
			var $_query = { action : "get-metacritics-status" }	
			AjaxCall(url, $_query).done( storeList )
		}

		function getUpdateQuery($id, $status){
			var $query;
			if($from === 'critics'){
				$query = { action: "update-statuscontroller" , id : $id, status : $status , from : $from }
			}else if($from === 'merchants' && $website != null){
				$query = { action: "update-statuscontroller" , id : $id, status : $status , from : $from, site: $website}
			}
			return $query;
		}

		function AjaxUpdateStatus($_query){
			AjaxCall(url, $_query).done(function(data){
				if(!data){
					if ($_query.status == 'ON') {
						$('#input-'+$_query.id).removeClass('button-on');
						$('#input-'+$_query.id).addClass('button-off');
						$('#input-'+$_query.id).val('OFF');
					}else{
						$('#input-'+$_query.id).removeClass('button-off');
						$('#input-'+$_query.id).addClass('button-on');
						$('#input-'+$_query.id).val('ON');
					}
					$('.btn-status').removeAttr("disabled");
					alertMsg("Successfully update the id "+$_query.id+" ");
				}else
					alertMsg("There's something wrong please try again")
			});
		}
		function storeList(data){
			var append = (data.to == 'merchant') ? '.append-merchants' : '.append-critics';
			$(append).empty();
			var res = data.data;
			for (var i in res){
				var val = (res[i].status == 'enabled') ? 'ON': 'OFF' ;
				var valClass = (val == 'ON') ? 'button-on' : 'button-off' ; 
				var app  = 	'<div class="col-md-6 col-lg-6 col-xl-3 store-list-div">';
					app += 		'<div class="div-merchant store-list-card" data-id='+res[i].id+' data-name='+res[i].merchant+'>';
					app += 			'<div class="card-body store-list"><p>'+res[i].merchant+' '+res[i].id+'</p></div>';
					app += 			'<div><input id="input-'+res[i].id+'" class="btn-status '+valClass+'" type="button" value='+val+'></div>';
					app += 		'</div>';
					app +=	'</div>';
				$(append).append(app);
			}
			$from = append.split("-")[1];
		}
	</script>
	<style>
		.sc-card-bulitin {
			position: relative;
			top: 20px;
			padding-left: 20px;
			padding-right: 20px;
			padding-bottom:15px;
			color: #fff;
			letter-spacing: 2px;
			font-weight: 400;
		}
		.sc-cb-ul-menu {
			list-style-type: none;
			padding:  0; 
			position: absolute; 
			top: 15px;
			left: 100px;
			color: #fff;
		}
		.sc-li-btn {
			cursor: pointer;
			display: inline-block;
			padding: 5px 15px 5px 15px;
			border-radius: 5px;
		}
		.active-sc-menu {
			background-color: rgba(255, 255, 255, .2);
		}
		.rating-title{
			display: inline-block; 
			margin-top:10px;
			margin-bottom: 0;
			margin-right: 10px;
			color:#5b5b5b;
		}
		.pad-lr-20{
			padding-left:20px;
			padding-right:20px;
		}
		.store-list{
			padding:15px 15px 0 15px;
		}
		.store-list-div{
			padding-bottom:25px;
			border-radius: 5px;
		}
		.store-list-card {
			box-shadow: 0 4px 20px 0px rgb(0 0 0 / 14%), 0 5px 10px -5px rgb(107 109 112 / 40%);
			overflow: hidden;
			border-radius:5px;
		}
		.button-on { background: linear-gradient(60deg, #2576cc, #2472c6) !important ;}
		.button-off{ background: linear-gradient(60deg, #e5b935, #e1b44a) !important ;}

		#modal-confirmation,
		.btn-status{
			background: transparent;
			border: none;
			/* border-radius: 0 0 5px 5px; */
			cursor: pointer;
			outline: none;
			text-align: center;
			color: #fff;
			letter-spacing: 2px;
			width: 100%;
			font-weight: 700;
			padding: 5px;
		}
		.store-list p{
			letter-spacing: 1.5px;
			font-weight: 700;
		}
		#confimation-header-style{
			font-size: 20px;
			font-weight: 700;
			padding-top: 5px;
			padding-bottom: 5px;
		}
		#confirmation-body-style{
			padding-top: 10px;
			padding-bottom: 10px;
		}
	</style>
<?php $this->end(); ?>

<?php $this->start('body')?>
	<div class="container-fluid">
		<div class="row">
			<div class="col-lg-12 col-md-12 mtop-35px">
				<div class="card card-style card-normalmode">
					<div class="card-body no-padding"> 
						<div class="card-div-overflow-style row-1-card-div-overflow-style row-1-card-div-overflow-style-1">
							<p class="card-bulletin sc-card-bulitin">MENU :</p>
							<div class="d-xl-none" style="position: absolute; top: 20px;right: 20px; color: #fff;cursor: pointer;font-size: 18px;"><i class="fal fa-bars"></i></div>
							<ul class="sc-cb-ul-menu d-xl-block" style="display: none;">
								<li class="sc-li-btn active-sc-menu" id="sc-merchant-div">Merchant</li>
								<li class="sc-li-btn" id="sc-metacritics-div">Metacritics</li>
							</ul>
						</div>
					</div>
					<div class="card-div-overflow-style text-dark" style="position:relative;margin-top:5px;margin-bottom:5px; ">
						<div class="row" style="margin: 0;padding-top: 10px;padding-bottom: 10px;">
							<div class="div-topheader-1 col-lg-10 pad-lr-20">
								<p class="rating-title">Note: By setting the button to OFF it will be disabled all offers and will not be displayed in website and vice versa</p>
							</div>
							<div class="col-lg-2 div-site-hide" style="display:none">
								<div class="dropdown-website row-4-card-div-overflow-style-2">
									<div class="selected-website">
										<span class="selected-data"><input id="website-btn" class="website-btn" type="button" value="AKS"></span>
										<span class="position-icon-1"><i class="fas fa-caret-down" ></i></span>
									</div>
									<ul class="website-menu" style="display:none;">
										<li class='website-items' data-website="aks">AKS</li>
										<li class='website-items' data-website="cdd">CDD</li>
										<li class='website-items' data-website="brexitgbp">BREXITGBP</li>
									</ul>
								</div>
							</div>					
						</div>
					</div>
					<div class="sc-content" style="padding-bottom: 10px;">
						<div class="sc-content-div sc-merchant-div">
							<div class="card-body no-padding">
								<div class="row append-merchants">

								</div>
							</div>
						</div>
						<div class="sc-content-div sc-metacritics-div" style="display: none;">
							<div class="card-body no-padding">
								<div class="row append-critics">
								
								</div>
							</div>
						</div>
					</div>	
				</div>	
			</div>
		</div>
	</div>
<?php $this->end()?>
