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
		
		$.when( getMerchant(), getEdition() ).then( () => {
			AjaxCall(url, $dataReq).done( ajaxSuccess )
		})

		//search filder merchant
		$(document).on('click input', '.me-merchant-selinp',function(){
			$('.dropdown-menu-div').hide();
			$('.me-dmd-merchant').show().empty();
			var matcher = new RegExp( regExpEscape(this.value) , "i");
			var getOuput = conMerchant.filter(function (items) {
				return matcher.test(items.search)
			});
			for(var i in getOuput){
				$('.me-dmd-merchant').append(getOuput[i].toAppend) 
			}
		});

		//search filder edition
		$(document).on('click input', '.me-edition-selinp',function(){
			$('.dropdown-menu-div').hide();
			$('.me-dmd-edition').show().empty();
			var matcher = new RegExp( regExpEscape(this.value) , "i");
			var getOuput = conEdition.filter(function (items) {
				return matcher.test(items.search)
			});
			var displayTop = ['1','16','7','5','4','33'];
			for(var i in getOuput){
				if($.inArray(getOuput[i].id, displayTop) != -1) 
					$('.me-dmd-edition').prepend(getOuput[i].toAppend) 
				else
					$('.me-dmd-edition').append(getOuput[i].toAppend) 
			}
		});

		$(document).on('click', '.me-dd-select-site',function(){
			$('.dropdown-menu-div').hide();
			$('.dmd-select-site').show();
		});

		//Select Website
		$(document).on('click', '.dmds-select-site',function(){
			$('.dropdown-menu-div').hide();
			$('.dd-btn-text').html($(this).html())
			$('#me-check-display').empty();
            $('.me-select-input').val('');
            $dataReq.merchant = '0', $dataReq.edition = '0';
            var indexInput = $(this).parent().prevObject.index();
            if($(this).parent()[0].children.length == 3 ){
                $dataReq.website = (indexInput == 0 ) ? inputsSite[0].site : (indexInput == 1 ) ? inputsSite[1].site : (indexInput == 2 ) ? inputsSite[2].site : '';
                setStorage('sessionStorage','website',JSON.stringify($dataReq.website))
                AjaxCall(url, $dataReq).done( ajaxSuccess );
            }else 
				window.location.reload();
		});
		
		//Select Merchant/Edition
		$(document).on('click', '.dmds-merchant, .dmds-edition', function(){
			switch ($(this).parent().attr('data-dropdown')) {
				case 'Merchant':
					var $value = $(this).attr('data-me-merchant-ni')+' '+$(this).attr('data-merchant-id-ni');
					$dataReq.merchant = $(this).attr('data-merchant-id-ni');
					$('.me-merchant-selinp').val($value);
				break;
				case 'Edition':
					var $value = $(this).attr('data-me-edition-ni')+' '+$(this).attr('data-edition-id-ni');
					$dataReq.edition = $(this).attr('data-edition-id-ni');
					$('.me-edition-selinp').val($value);
				break;
				default:
					$dataReq.merchant = '0';
					$dataReq.edition  = '0';
					$('.me-select-input').val('');
				break;
			}
		});
		
		$(document).on('click', '#fire', function(data){
			if($dataReq.merchant == '0' && $dataReq.edition != '0' || $dataReq.merchant != '0' && $dataReq.edition == '0' )
				alertMsg("One of input is empty")
			else if ($('.me-select-input').val() == ''){
				$dataReq.merchant = '0';
				$dataReq.edition  = '0';
				$('#me-check-display').empty();
            	AjaxCall(url, $dataReq).done( ajaxSuccess );
			}
			else{
				$('#me-check-display').empty();
				AjaxCall(url, $dataReq).done( ajaxSuccess );
			}
		});

	//end of Jquery Dom	
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
					'toAppend': '<div class="dropdown-menu-div-sub dmds-edition" data-me-edition-ni="'+ name +'" data-edition-id-ni='+data[i].id+'><span class="dmds-data-name">'+ name +'</span> = <span class="dmds-data-id"> '+data[i].id+' </span></div>'
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
					'toAppend': '<div class="dropdown-menu-div-sub dmds-merchant" data-me-merchant-ni="'+ name +'" data-merchant-id-ni='+data[i].vols_id+'><span class="dmds-data-name">'+ name +'</span>  <span class="dmds-data-id"> '+data[i].vols_id+' </span></div>'
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
				app +=  '<div><span class="me-res"><a class="url-redirect" href='+result[i].buy_url+' target="_blank">'+result[i].buy_url+'</a></span></div>';
				app += '</div>';
			$('#me-check-display').append(app);
		}
		$('.dd-btn-text').html(data.success.returnWebsite.toUpperCase())
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
	.me-text{ padding-left:2px; }
	.me-res { font-weight:500; }
    .me-text, .me-res { font-size: 12px; }
    .url-redirect { word-break: break-all; }
	.me-text{
        background-color:#f3f3f3;
        color: #6b6d70;
        border-radius:5px;
        font-weight:500;
        width: 70px;
        display: inline-block;
        margin-right: 5px;
    }
    .text-note{
		text-decoration:underline;
        margin:0;
    }
	#fire{
		padding: 6px 15px 6px 15px;
		border-radius: 5px;
		outline: none;
		border: none;
		cursor: pointer;
		letter-spacing: 2px;
		font-weight: 700;
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
							<h4 style="position: relative;top: 20px;padding-left: 20px;padding-right: 20px; padding-bottom: 10px; color: #fff;letter-spacing: 1px;">
							Merchant Edition Check
							</h4>
							<p style="position: relative;top: 3px;padding-left: 20px;padding-right: 20px;color: #fff;font-size: 13px;">
								Use this to find latest created offers by merchant and edition
							</p>
						</div>
						<div class="dropdown" style="width: 150px;position: absolute;right: 0;top: 50%;transform: translate(-20px, -50%);">
							<div class="dropdown" style="background-color: transparent;">
								<button  name="" class="input-text-class dropdown-inputbox dropdown-btn me-dd-select-site" ><span class="dd-btn-text float-left">Select site</span><span class="float-right" style="top:2.3px;right: 10px;position:relative;"><i class="fas fa-angle-down"></i></span></button>
								
								<div class="dropdown-menu-div dmd-select-site" >
									<div class="dropdown-menu-div-sub dmds-select-site">AKS</div>
									<div class="dropdown-menu-div-sub dmds-select-site">CDD</div>
									<div class="dropdown-menu-div-sub dmds-select-site">BREXIT</div>
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
							<div class="col-lg-5">
								<div class="dropdown">
									<input type="text" name="" class="input-text-class dropdown-inputbox me-select-input me-merchant-selinp" autocomplete='off' style="left: 0;border-left: solid 2px #ccc;border-right: none;padding: 0 5px; border-radius: 5px 0 0 5px;" required>
									<i class="input-text-i fal fa-angle-down"></i>
									<span class="input-text-span me-si-span" style="left: 5px">Select Merchant</span>
									<span class="input-text-border"></span>

									<div class="dropdown-menu-div me-dmd-merchant scrollbar-custom" data-dropdown="Merchant">
										<!-- data from database -->
									</div>
								</div>
							</div>
							<div class="col-lg-5">
								<div class="dropdown">
									<input type="text" name="" class="input-text-class dropdown-inputbox me-select-input me-edition-selinp" autocomplete='off' style="left: 0;border-left: solid 2px #ccc;border-right: none;padding: 0 5px; border-radius: 5px 0 0 5px;" required>
									<i class="input-text-i fal fa-angle-down"></i>
									<span class="input-text-span me-si-span" style="left: 5px">Select Edition</span>
									<span class="input-text-border"></span>

									<div class="dropdown-menu-div me-dmd-edition scrollbar-custom" data-dropdown="Edition">
										<!-- data from database -->
									</div>
								</div>
							</div>
							<div class="col-lg-2">
								<input type="button" id="fire" class="button-go btn-primary" data-search="go" value="Check">
							</div>
						</div>
					</div>
					<div class="col-12 no-padding">
						<div id="me-check-display">
						
						</div>
					</div>
				</div>
			</div>
		</div>
	</div>
</div>
<?php $this->end()?>

