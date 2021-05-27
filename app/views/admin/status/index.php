<?php $this->setSiteTitle("Status Controller"); ?>
<?php $this->start('head'); ?>
	<script>
		$(function() {
			setActiveTab(getUrlParameter('tab'));

			$(document).on('click', '.sc-li-btn', function(){
				$('.sc-li-btn').removeClass('active-sc-menu');
				$('#'+$(this).attr('id')).addClass('active-sc-menu');
				$('.sc-content-div').hide();
				$('.'+$(this).attr('id')).show();

				switch($(this).attr('id')){
					case 'sc-merchant-div':
						var param = '';
					break;
					case 'sc-metacritics-div':
						var param = '?tab=metacritics';
					break;
				}
				var newurl = window.location.protocol + "//" + window.location.host + window.location.pathname + param;
				window.history.pushState({ path: newurl }, '', newurl);
			});
		}); // end document ready function

		function setActiveTab($param){
			$('.sc-li-btn').removeClass('active-sc-menu');
			$('.sc-content-div').hide();

			switch($param){
				case 'metacritics':
					var divClassID = 'sc-metacritics-div';
				break;
				default:
					var divClassID = 'sc-merchant-div';
				break;
			}

			$('.'+divClassID).show();
			$('#'+divClassID).addClass('active-sc-menu');
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
					<div class="sc-content" style="padding-bottom: 10px;">
						<div class="sc-content-div sc-merchant-div">
							merchant store
						</div>
						<div class="sc-content-div sc-metacritics-div" style="display: none;">
							metacritics
						</div>
					</div>	
				</div>	
			</div>
		</div>
	</div>
<?php $this->end()?>
