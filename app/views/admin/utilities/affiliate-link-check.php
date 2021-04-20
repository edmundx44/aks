<?php
	$url_check = (isset($_GET['url_check']) AND $_GET['url_check'] == 'buy_url_raw')? $_GET['url_check']: 'buy_url';
	$text = ($url_check == 'buy_url_raw') ? 'Buy Url Raw' : 'Buy Url';
?>

<?php $this->setSiteTitle($this->pageTitle); ?>
<?php $this->start('head'); ?>
	<link rel="stylesheet" href="<?=PROOT?>vendors/css/utilities-page.css" media="screen" title="no title" charset="utf-8">
    <script type="text/javascript" src="https://cdnjs.cloudflare.com/ajax/libs/underscore.js/1.12.0/underscore-min.js"></script>

<script type="text/javascript">
	var $url = url+'utilities/affiliateCheck';	
	$(function(){
		//removeThe OptionSite stored
		if (!removeExistingItem('sessionStorage','OptionSite',uri)){
			console.log('Item has been removed');
		}
		
		if(sessionStorageCheck()){
			var object = JSON.parse(getStorage('sessionStorage','OptionSite'));
			if(object != null){
				site = returnSite(object.site);
				if(site != 'invalid'){
					// ajaxCall_RDB($url,'POST',site).done(function(data){
					// 	done_ajaxCall_RDB(site,data)
					// })
				}else{ if(removedKeyNormal($type,$key)) console.log("Item has been removed") } //remove key if invalid site
			}else{
				//console.log('NO VALUE DEFAULT IS AKS');
				//if null default value is aks
				// ajaxCall_RDB($url,'POST',inputs[0].site).done(function(data){
				// 	done_ajaxCall_RDB(inputs[0].site,data)
				// })
			}
		}		


		//rendered on first load
		$('.dropdown-div').html(OptionSite(inputs,'opt-site-alc','slc-options','custom-bkgd')); //OptionSite na a sa custom.js
		// na na ni sa index.php sa dashboards
		//FOR DROP DOWN SELECT ANIMATION
		$('.dropdown-div').click(function () {
			$(this).find('.dropdown-menu').slideToggle(200);
		});

		$('.dropdown-div').focusout(function () {
			$(this).find('.dropdown-menu').slideUp(200);
		});

		$(document).on('click', '.opt-site-alc', function(){
			$('.dropdown-div').html(OptionSite(inputs,'opt-site-alc','slc-options','custom-bkgd')); //OptionSite na a sa custom.js
			var indexInput = $(this).parent().prevObject.index(); //get the index of li
			if($(this).parent()[0].childNodes.length == 3 ){
				site = ((indexInput == 0 ) ? inputs[0].site : (indexInput == 1 )) ? inputs[1].site : (indexInput == 2 ) ? inputs[2].site : '';
				var $data = { 'site': site, 'path': $url }
				if(sessionStorageCheck()){ setStorage('sessionStorage','OptionSite',JSON.stringify($data)) }
			    // ajaxCall_RDB($url,'POST',site).done(function(data){
				// 	done_ajaxCall_RDB(site,data)
				// })
			}else{ window.location.reload(); }
		});
	});
</script>
<style>
	.div-topheader{
		display:flex;
	}
	.div-topheader-1{
		width:100%;
	}
	.div-topheader-2{
		width:10%;
	}
	.TU-btns input[type=button]{ 
		font-size: 12px !important;
		padding: 1px 5px 1px 5px;
		background-color: #fff;
		color: #3f51b5; 
		margin-right: 8px;
		letter-spacing: 2px;
		font-weight: bold;
		border-color: #2e6da4;
		border-radius: 10px;
	}
	/*.bur-sm-btn input[type=button],
	.store input[type=button]{ 
		padding: 2px 6px 2px 6px;
		background-color: #5bc0de;
		color: #fff; 
		margin-right: 8px;
		letter-spacing: 1.5px;
		font-weight: bold;
		border-color: #50b7c8;
	}*/
	.TU-btns input[type=button]:hover{
		background-color:#0e2082e8;
		color: #fff !important; 
	}
	.act-tu-btn{
		color: #fff !important;
		background-color: #3f51b5 !important; 
	}
	.p-text{
		letter-spacing: 2px;
	}
</style>
<?php $this->end()?> 


<?php $this->start('body')?>
	<div class="container-fluid">
		<div class="row">
			<div class="col-lg-12 col-md-12 mtop-35px">
				<div class="card card-style">
					<div class="card-body rdl-card-main-wrap no-padding">
						<!-- HEADER STARTS -->
						<div class="card-div-overflow-style row-4-card-div-overflow-style row-4-card-div-overflow-style-2" style ="padding-bottom:20px;">
							<div class="div-topheader" style="padding-top: 20px; padding-left: 10px; color: white;">
								<div class="div-topheader-1 TU-btns">
									<h5 style="display: inline-block; margin-right: 10px;">Affiliate Links</h5>
									<i class="fa fa-hand-o-right" aria-hidden="true"></i>
									<p style="font-size:12px;font-weight: 500;display: inline-block; padding:0;margin:0">
										<input id="btn-bu" class="btn <?= ($url_check == 'buy_url') ? 'act-tu-btn':'';?>" type="button" name="buy_url" value="BUY URL">
									</p>
									<!-- <p style="font-size:12px;font-weight: 500;display: inline-block; padding:0;margin:0">
										<input id="btn-bu" class="btn <?= ($url_check == 'buy_url_raw') ? 'act-tu-btn':'';?>" type="button" name="buy_url_raw" value="BUY URL RAW">
									</p> -->
									<p style="font-size:12px;font-weight: 500;">Checks the affiliate of the <b class="p-text"><?= $text ?></b> on every merchant</p>
								</div>
							</div>
						</div >
						<!-- CONTENT STARTS -->
						<div>
							<div class="dropdown-box dbox-hide" style="padding-bottom: 5px;">
 								<div class="dropdown-div" style="width: 150px;">
									<!-- in custom.js  OptionSite(inputs,className,classParent,bgColor) -->
								</div>
								<div class="pull-right">
									<input style="color:#fff;" type="button" name="" class="m-d col-xs-3 btn btn-delete" id="btn-getchksumreports" value="Show Errors">
								</div>
							</div>
							<div class="col-xs-12 div-body-table" id="div-DBL-body">
									test
							</div>
						</div>
					</div>
				</div>
			</div>
		</div>
	</div>
<?php $this->end()?> 