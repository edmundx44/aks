<?php $this->setSiteTitle($this->pageTitle); ?>
<?php $this->start('head'); ?>
<script type="text/javascript">
	var $dataReq = {
		action: 'merchant_edition_price_tool',
		website: 'aks',
		merchant: '0',
		edition: '0',
	};
	var conEdition = [];
	var conMerchant = [];

	$(function() {

		var init = safelyParseJSON(getStorage('sessionStorage','website')) 
		if( init && returnSite(init) != null){
			$dataReq.website = init;
		}else 
			removedKeyNormal('sessionStorage','website') 
		
		$.when(

		)
		Promise.all([ 
			getMerchant() ,
			getEdition() , 
			AjaxCall(url, $dataReq).done( ajaxSuccess ) 
		]).then(() => {
			console.log('All Ajax done with success!')
		}).catch((response) => {
			alert('All Ajax done: some failed!')
		})

		$(document).on('click input', '.me-merchant-selinp',function(){
			$('.dropdown-menu-div').hide();
			$('.me-dmd-merchant').show().empty();

			// var matcher = new RegExp( regExpEscape(this.value) , "i");
			// var getOuput = conEdition.filter(function (items) {
			// 	return matcher.test(items.search)
			// });

			// var displayTop = ['1','16','7','5','4','33'];
			// for(var i in getOuput){
			// 	if($.inArray(getOuput[i].id, displayTop) != -1) {
			// 		$('.select-edition-div').prepend(getOuput[i].toAppend) 
			// 	} else {
			// 		$('.select-edition-div').append(getOuput[i].toAppend) 
			// 	}
			// }

			// $append = '<div class="dropdown-menu-div-sub dmds-edition" data-nameni="+2000 v-bucks" data-idni="159">';
			// $append += '<span class="dmds-data-name">+2000 v-bucks</span> = <span class="dmds-data-id"> 159 </span>';
			// $append += '</div>';
			// $append += '<div class="dropdown-menu-div-sub dmds-edition" data-nameni="1 pc 5 years" data-idni="129">';
			// $append += '<span class="dmds-data-name">1 pc 5 years</span> = <span class="dmds-data-id"> 129 </span>';
			// $append += '</div>';
			// $append += '<div class="dropdown-menu-div-sub dmds-edition" data-nameni="1 pc 5 years" data-idni="129">';
			// $append += '<span class="dmds-data-name">1 pc 5 years</span> = <span class="dmds-data-id"> 129 </span>';
			// $append += '</div>';
			// $('.me-dmd-merchant').append($append) ;

		});
		$(document).on('click input', '.me-edition-selinp',function(){
			$('.dropdown-menu-div').hide();
			$('.me-dmd-edition').show().empty();

			// var matcher = new RegExp( regExpEscape(this.value) , "i");
			// var getOuput = conMerchant.filter(function (items) {
			// 	return matcher.test(items.search)
			// });

			// for(var i in getOuput){
			// 	$('.select-merchant-div').append(getOuput[i].toAppend) 
			// }

			// $append = '<div class="dropdown-menu-div-sub dmds-edition" data-nameni="+2000 v-bucks" data-idni="159">';
			// $append += '<span class="dmds-data-name">+2000 v-bucks</span> = <span class="dmds-data-id"> 159 </span>';
			// $append += '</div>';
			// $append += '<div class="dropdown-menu-div-sub dmds-edition" data-nameni="1 pc 5 years" data-idni="129">';
			// $append += '<span class="dmds-data-name">1 pc 5 years</span> = <span class="dmds-data-id"> 129 </span>';
			// $append += '</div>';
			// $append += '<div class="dropdown-menu-div-sub dmds-edition" data-nameni="1 pc 5 years" data-idni="129">';
			// $append += '<span class="dmds-data-name">1 pc 5 years</span> = <span class="dmds-data-id"> 129 </span>';
			// $append += '</div>';
			// $('.me-dmd-edition').append($append);

		});

		$(document).on('click', '.me-dd-select-site',function(){
			$('.dropdown-menu-div').hide();
			$('.dmd-select-site').show();
		});

		$(document).on('click', '.dmds-select-site',function(){
			$('.dropdown-menu-div').hide();
			$('.dd-btn-text').html($(this).html())
		});
		
		
	});

	function getEdition(){
		conEdition = []
		var dataRequest =  {
			action: 'get-edition',
		}
		AjaxCall(url, dataRequest).done(function(data) {
			for(var i in data){
				var name = data[i].name.substr(0,1).toUpperCase()+data[i].name.substr(1).toLowerCase();
				conEdition.push({
					'id' : data[i].id,
					'name' : name,
					'search': name +' '+ data[i].id,
					'toAppend': '<div class="me-merchant" data-me-edition-ni="'+ name +'" data-edition-id-ni='+data[i].id+'><span class="me-data-name">'+ name +'</span> = <span class="me-data-id"> '+data[i].id+' </span></div>'
				});
			}
		}).always(function() {});
	}

	function getMerchant(){
		conMerchant = []
		var dataRequest =  {
			action: 'get-merchant',
		}
		AjaxCall(url, dataRequest).done(function(data) {
			for(var i in data){
				var name = data[i].vols_nom.substr(0,1).toUpperCase()+data[i].vols_nom.substr(1).toLowerCase();
				conMerchant.push({
					'id' : data[i].vols_id,
					'name' : name,
					'search': name +' '+ data[i].vols_id,
					'toAppend': '<div class="me-merchant" data-me-merchant-ni="'+ name +'" data-merchant-id-ni='+data[i].vols_id+'><span class="me-data-name">'+ name +'</span> = <span class="me-data-id"> '+data[i].vols_id+' </span></div>'
				});
			}
		}).always(function() {});
	}

	function ajaxSuccess(data) {
		var result = data.success.data;
		for(var i in result){
			var app =  '<div class="result-merchant card-style mb-3">';
				app +=  '<p class="text-note">Create by '+result[i].created_by+' on '+result[i].created_time+'</p>';
				app +=  '<div> <span class="me-text">Merchant</span><span class="me-res">'+result[i].merchant+'</span> </div>';
				app +=  '<div class="div-inline"><span class="me-text">Price</span><span class="me-res">'+result[i].price+'</span></div>';
				app +=  '<div class="div-inline"><span class="me-text">Edition</span><span class="me-res">'+result[i].edition+'</span></div>';
				app +=  '<div class="div-inline"><span class="me-text">Region</span><span class="me-res">'+result[i].region+'</span></div>';
				app +=  '<div><span class="me-res">'+result[i].search_name+'</span></div>';
				app +=  '<div><span class="me-res"><a class="url-redirect aks_color" href='+result[i].buy_url+' target="_blank">'+result[i].buy_url+'</a></span></div>';
				app += '</div>';
			$('#merchant-edition').append(app);
		}
		$('#website-btn').val(data.success.returnWebsite.toUpperCase())
	}
</script>

<style>
	.me-select-input:focus ~ .me-si-span {
		right:  0 !important;
	}
	.dropdown-btn {
		left: 0;
		border: transparent;
		/*border-left: solid 1px transparent;*/
		width: 100%;
		border-radius: 5px;
		cursor: pointer;
		background-color: #007bff;
		color: #fff;
		font-size: 18px;
	}
	button:focus {
		outline: none !important;
	}
	.dropdown-btn:hover{
		background-color: #0069d9;
	}
</style>
<?php $this->end(); ?>

<?php $this->start('body')?>
<div class="container-fluid">
	<div class="row">
		<div class="col-lg-12 col-md-12 mtop-35px">
			<div class="card card-style card-normalmode">
				<div class="card-body no-padding" style=""   > 
					<div class="card-div-overflow-style row-1-card-div-overflow-style-1" style="padding-bottom: 8px;position: relative;z-index: 2;">
						<div>
							<p style="position: relative;top: 20px;padding-left: 20px;padding-right: 20px;color: #fff;letter-spacing: 1px;">
							Merchant Edition Check
							</p>
							<p style="position: relative;top: 3px;padding-left: 20px;padding-right: 20px;color: #fff;font-size: 13px;">
								Check using Merchant and Edition
							</p>
						</div>
						<div class="dropdown" style="width: 150px;position: absolute;right: 0;top: 50%;transform: translate(-20px, -50%);">
							<div class="dropdown" style="background-color: transparent;">
								<button  name="" class="input-text-class dropdown-inputbox dropdown-btn me-dd-select-site" ><span class="dd-btn-text float-left">Select site</span><span class="float-right" style="top:2.3px;right: 10px;position:relative;"><i class="fas fa-angle-down"></i></span></button>
								
								<div class="dropdown-menu-div dmd-select-site" >
									<div class="dropdown-menu-div-sub dmds-select-site">AKS</div>
									<div class="dropdown-menu-div-sub dmds-select-site">CDD</div>
									<div class="dropdown-menu-div-sub dmds-select-site">BREX</div>
								</div>
							</div>
							<!-- <button class="btn btn-primary dropdown-toggle col-12 me-website-btn" data-toggle="dropdown" >Select Site</button>
							<div class="dropdown-menu col-12" aria-labelledby="dropdownMenuButton" style="width: 150px;min-width: unset;">
								<span class="dropdown-item">AKS</span>
								<span class="dropdown-item">CDD</span>
								<span class="dropdown-item">BREX</span>
							</div> -->
						</div>
					</div>
					<div class="me-content-div" style="">
						<div class="row" style="padding: 10px 0;">
							<div class="col-6">
								<div class="dropdown">
									<input type="text" name="" class="input-text-class dropdown-inputbox me-select-input me-merchant-selinp" autocomplete='off' style="left: 0;border-left: solid 2px #ccc;border-right: none;padding: 0 5px;" required>
									<i class="input-text-i fal fa-angle-down"></i>
									<span class="input-text-span me-si-span" style="left: 5px">Select Merchant</span>
									<span class="input-text-border"></span>

									<div class="dropdown-menu-div me-dmd-merchant">
										<!-- data from database -->
									</div>
								</div>
							</div>
							<div class="col-6">
								<div class="dropdown">
									<input type="text" name="" class="input-text-class dropdown-inputbox me-select-input me-edition-selinp" autocomplete='off' style="left: 0;border-left: solid 2px #ccc;border-right: none;padding: 0 5px;" required>
									<i class="input-text-i fal fa-angle-down"></i>
									<span class="input-text-span me-si-span" style="left: 5px">Select Edition</span>
									<span class="input-text-border"></span>

									<div class="dropdown-menu-div me-dmd-edition">
										<!-- data from database -->
									</div>
								</div>
							</div>
						</div>
					</div>
				</div>
			</div>
		</div>
	</div>
</div>
<?php $this->end()?>

