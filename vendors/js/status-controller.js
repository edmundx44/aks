var $from = null;
		var $website = null;
		$(function() {

			setActiveTab(getUrlParameter('tab'));
			
			$(window).bind('popstate', function(event) {
				var state = event.originalEvent.state;		
			});

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
						var ajax = AjaxStores();
					break;
					case 'sc-metacritics-div':
						var param = '?tab=metacritics';
						$('.div-site-hide').hide();
						var ajax = AjaxCritics();
					break;
				}
				var newurl = window.location.protocol + "//" + window.location.host + window.location.pathname + param;
				window.history.pushState({ path: newurl, ajax: ajax }, '', newurl);
			});

			$(document).on('click', '.website-items', function(){
				$('#website-btn').val($(this).attr('data-website').toUpperCase())
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
						footer: '<input id="modal-confirmation-status" class="col-6 button-on" style="margin:0 auto; border-radius:5px;" type="button" value="YES">'
					}
					confirmDialog($modalContent, "modal-confirmation-status",function(e){
						$_query = getUpdateQuery($id, $status);
						if($_query !== undefined){
							$(this).val("Loading");
							$('.btn-status').attr("disabled","disabled")
							AjaxUpdateStatus($_query);
						}
					})

				}else
					alertMsg("Invalid Status Please reload the page", "bg-danger")	
			});
		}); // end document ready function
		
		function confirmDialog($con, confirmationBtnId, onConfirm){
			//id btn in the footer modalContent
			var fClose = function(){
				modal.modal("hide");
			};
			var modal = $("#report-modal-confirmation");
			modal.modal('show');
			$('#confirmation-header-tittle').empty().html($con.header);
			$('#confirmation-body-div').empty().append($con.body);
			$('#confirmation-footer-div').empty().append($con.footer);	
			$('#'+confirmationBtnId).unbind().one('click', onConfirm).one('click', fClose);
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
					alertMsg("Successfully update the id "+$_query.id+" ", "bg-success");
				}else
					alertMsg("There's something wrong please try again", "bg-danger")
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