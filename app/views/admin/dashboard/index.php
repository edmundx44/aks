<?php $this->start('head'); ?>

<script src="https://cdn.jsdelivr.net/npm/chart.js@2.8.0"></script>
<script type="text/javascript" src="<?=PROOT?>vendors/js/dashboard-page.js"></script>
<link rel="stylesheet" href="<?=PROOT?>vendors/css/dashboard-page.css" media="screen" title="no title" charset="utf-8">

<?php $this->end(); ?>

<?php $this->start('body')?>

<div class="container-fluid">
	<div class="row">
		<div class="col-lg-12 col-md-12 mtop-35px">
			<div class="card card-style card-normalmode">
				<div class="card-body no-padding row-1-card-body"> 
					<div class="card-div-overflow-style row-1-card-div-overflow-style row-1-card-div-overflow-style-1">
						<p class="card-bulletin">Bulletin</p>
						<p class="card-bulletin-desc">Lorem Ipsum is simply dummy text of the printing and typesetting industry.</p>
					</div>
				</div>
			</div>

		</div>
		<!-- <div class="col-lg-6 col-md-12 mtop-35px">
			<div class="card card-style">
				<div class="card-body no-padding row-1-card-body"> 
					<div class="card-div-overflow-style row-1-card-div-overflow-style row-1-card-div-overflow-style-2"> </div>
				</div>
			</div>
		</div> -->
	</div>

	<div class="row">
		<div class="col-xxl-6 col-xl-3 col-md-12 mtop-35px">
			<div class="card card-style card-normalmode">
				<div class="card-header no-padding row-2-card-header" style=""> 
					<div class="text-center card-div-overflow-style row-2-card-div-overflow-style row-2-card-div-overflow-style-1">
						<i class="fa fa-ban row-2-icon" aria-hidden="true"></i>
					</div>
					<p class="card-title-p card-title-p-normal disable-count"></p>
					<p class="card-val-p card-val-p-normal">Disabled</p>
					<p class="card-val-p-sub card-val-p-sub-normal"><span class="disabled-what menu-disabled-what"></span> - SELECTED</p>
				</div>
				<div class="card-body no-padding card-body-style">
					<div class="card-body-div"> 
						<div class="pull-right card-body-div-sub">
							<i class="fa fa-eye view-more-icon" aria-hidden="true" data-to="menu-disabled"> </i> 
							<span class="card-body-div-sub-span" data-to="menu-disabled">view more</span>
						</div>
						
						<i class="fa fa-sliders float-left card-body-div-i" data-what="menu-disabled" aria-hidden="true"></i>
						<div class="card-body-menu-div menu-disabled">
							<ul class="card-body-menu-div-ul">
								<li class="card-body-menu-div-li" data-to="menu-disabled"  data-what="Store"><i class="fa fa-chevron-circle-right" aria-hidden="true"></i><span class="cbm-span">Store</span></li>
								<li class="card-body-menu-div-li" data-to="menu-disabled"  data-what="Metacritics"><i class="fa fa-chevron-circle-right" aria-hidden="true"></i><span class="cbm-span">Metacritics</span></li>
							</ul>
						</div>
					</div>
				</div>
			</div>
		</div>
		<div class="col-xxl-6 col-xl-3 col-md-12 mtop-35px">
			<div class="card card-style card-normalmode">
				<div class="card-header no-padding row-2-card-header"> 
					<div class="text-center card-div-overflow-style row-2-card-div-overflow-style row-2-card-div-overflow-style-2">
						<i class="fa fa-snapchat row-2-icon" aria-hidden="true"></i>
					</div>
					<p class="card-title-p card-title-p-normal snapshot-count"></p>
					<p class="card-val-p card-val-p-normal"> Snapshot</p>
					<p class="card-val-p-sub card-val-p-sub-normal"><span class="snapshot-what menu-snapshot-what"></span> - SELECTED</p>

				</div>
				<div class="card-body no-padding card-body-style">
					<div class="card-body-div"> 
						<div class="pull-right card-body-div-sub">
							<i class="fa fa-eye view-more-icon" aria-hidden="true" data-to="menu-snapshot"> </i> 
							<span class="card-body-div-sub-span" data-to="menu-snapshot">view more</span>
						</div>
						
						<i class="fa fa-sliders float-left card-body-div-i" data-what="menu-snapshot" aria-hidden="true"></i>
						<div class="card-body-menu-div menu-snapshot">
							<ul class="card-body-menu-div-ul">
								<li class="card-body-menu-div-li" data-to="menu-snapshot" data-what="AKS"><i class="fa fa-chevron-circle-right" aria-hidden="true"></i><span class="cbm-span">AKS</span></li>
								<li class="card-body-menu-div-li" data-to="menu-snapshot" data-what="CDD"><i class="fa fa-chevron-circle-right" aria-hidden="true"></i><span class="cbm-span">CDD</span></li>
								<li class="card-body-menu-div-li" data-to="menu-snapshot" data-what="BREXIT"><i class="fa fa-chevron-circle-right" aria-hidden="true"></i><span class="cbm-span">BREXIT</span></li>
							</ul>
						</div>
					</div>
				</div>
			</div>
		</div>
		<div class="col-xxl-6 col-xl-3 col-md-12 mtop-35px">
			<div class="card card-style card-normalmode">
				<div class="card-header no-padding row-2-card-header"> 
					<div class="text-center card-div-overflow-style row-2-card-div-overflow-style row-2-card-div-overflow-style-3">
						<i class="fa fa-database row-2-icon" aria-hidden="true"></i>
					</div>
					
					<p class="card-title-p card-title-p-normal dbfeed-count"></p>
					<p class="card-val-p card-val-p-normal"> DB Feed</p>
					<p class="card-val-p-sub card-val-p-sub-normal"><span class="dbfeed-what menu-dbfeed-what"></span> - SELECTED</p>
				</div>
				<div class="card-body no-padding card-body-style">
					<div class="card-body-div"> 
						<div class="pull-right card-body-div-sub">
							<i class="fa fa-eye view-more-icon" aria-hidden="true" data-to="menu-dbfeed"> </i> 
							<span class="card-body-div-sub-span" data-to="menu-dbfeed">view more</span>
						</div>
						
						<i class="fa fa-sliders float-left card-body-div-i" data-what="menu-dbfeed" aria-hidden="true" ></i>
						<div class="card-body-menu-div menu-dbfeed">
							<ul class="card-body-menu-div-ul">
								<li class="card-body-menu-div-li" data-to="menu-dbfeed" data-what="AKS"><i class="fa fa-chevron-circle-right" aria-hidden="true"></i><span class="cbm-span">AKS</span></li>
								<li class="card-body-menu-div-li" data-to="menu-dbfeed" data-what="CDD"><i class="fa fa-chevron-circle-right" aria-hidden="true"></i><span class="cbm-span">CDD</span></li>
								<li class="card-body-menu-div-li" data-to="menu-dbfeed" data-what="BREXIT"><i class="fa fa-chevron-circle-right" aria-hidden="true"></i><span class="cbm-span">BREXIT</span></li>
							</ul>
						</div>
					</div>
				</div>
			</div>
		</div>
		<div class="col-xxl-6 col-xl-3 col-md-12 mtop-35px">
			<div class="card card-style card-normalmode">
				<div class="card-header no-padding row-2-card-header"> 
					<div class="text-center card-div-overflow-style row-2-card-div-overflow-style row-2-card-div-overflow-style-4">
						<i class="fa fa-random row-2-icon" aria-hidden="true"></i>
					</div>
					<p class="card-title-p card-title-p-normal">0</p>
					<p class="card-val-p card-val-p-normal">Others</p>
				</div>
				<div class="card-body no-padding card-body-style">
					<div class="card-body-div"> 
						<div class="pull-right card-body-div-sub">
							<i class="fa fa-eye view-more-icon" aria-hidden="true"> </i> 
							<span class="card-body-div-sub-span">view more</span>
						</div>
						
						<i class="fa fa-sliders float-left card-body-div-i" data-what="menu-others" aria-hidden="true"></i>
						<div class="card-body-menu-div menu-others">
							<ul class="card-body-menu-div-ul">
								<li class="card-body-menu-div-li"><i class="fa fa-chevron-circle-right" aria-hidden="true"></i><span class="cbm-span">Others</span></li>
								<li class="card-body-menu-div-li"><i class="fa fa-chevron-circle-right" aria-hidden="true"></i><span class="cbm-span">Others</span></li>
								<li class="card-body-menu-div-li"><i class="fa fa-chevron-circle-right" aria-hidden="true"></i><span class="cbm-span">Others</span></li>
							</ul>
						</div>
					</div>
				</div>
			</div>
		</div>
	</div>

	<div class="row">
		<div class="col-md-4 mtop-35px">
			<div class="card card-style card-normalmode">
				<div class="card-header no-padding row-3-card-header"> 
					<div class="card-div-overflow-style row-3-card-div-overflow-style row-3-card-div-overflow-style-1" style="padding: 10px;height: 210px;"> 
						<canvas id="priceToZeroPercent-1" class="priceToZeroPercent-canvas" height="120"></canvas>
					</div>
				</div>
				<div class="card-body">
					
				</div>
			</div>
		</div>
		<div class="col-md-4 mtop-35px">
			<div class="card card-style card-normalmode">
				<div class="card-header no-padding row-3-card-header"> 
					<div class="card-div-overflow-style row-3-card-div-overflow-style row-3-card-div-overflow-style-2" style="padding: 10px;height: 210px;">
						<canvas id="realDoubleCounts-1" class="priceToZeroPercent-canvas" height="120"></canvas>
					</div>
				</div>
				<div class="card-body">
					
				</div>
			</div>
		</div>
		<div class="col-md-4 mtop-35px">
			<div class="card card-style card-normalmode">
				<div class="card-header no-padding row-3-card-header"> 
					<div class="card-div-overflow-style row-3-card-div-overflow-style row-3-card-div-overflow-style-3" style="padding: 10px;height: 210px;">
						<canvas id="feedBotRuntime-1" class="priceToZeroPercent-canvas" height="120"></canvas>
					</div>
				</div>
				<div class="card-body">
					
				</div>
			</div>
		</div>
	</div>

	<div class="row">
		<div class="col-lg-6 col-md-12 mtop-35px">
			<div class="card card-style card-normalmode">
				<div class="card-body no-padding row-4-card-body"> 
					<div class="card-div-overflow-style row-4-card-div-overflow-style row-4-card-div-overflow-style-1"> </div>
				</div>
			</div>
		</div>
		<div class="col-lg-6 col-md-12 mtop-35px">
			<div class="card card-style card-normalmode">
				<div class="card-body no-padding row-4-card-body"> 

					<div class="card-div-overflow-style row-4-card-div-overflow-style row-4-card-div-overflow-style-2 check-width" style="color: white;"> 
						<div style="padding-top: 20px; padding-left: 10px;">
							<ul class="ul-tab-option m-fb-opt" style="display: none;">
								<i class="fa fa-sliders float-left card-body-div-fb" data-what="menu-feedbots"></i>
								<li class="fb-opt-1">FEED BOTS</li>
							</ul>
							<div class="card-body-menu-div-fbots menu-feedbots" style="color: #6b6d70 !important;">
								<ul class="card-body-menu-div-ul">
									<li class="m-feedboot-opt-li active-tab-1" data-m-tab="m-chksum"><i class="fa fa-chevron-circle-right" aria-hidden="true"></i><span class="cbm-span">Checksum</span></li>
									<li class="m-feedboot-opt-li" data-m-tab="m-sStore" data-feedbots="getSuccessStores"><i class="fa fa-chevron-circle-right" aria-hidden="true"></i><span class="cbm-span">Success</span></li>
									<li class="m-feedboot-opt-li" data-m-tab="m-fStore" data-feedbots="getFailedStores"><i class="fa fa-chevron-circle-right" aria-hidden="true"></i><span class="cbm-span">Fail</span></li>
									<li class="m-feedboot-opt-li" data-m-tab="m-scStorem" data-feedbots="getServerChargeStore"><i class="fa fa-chevron-circle-right" aria-hidden="true"></i><span class="cbm-span">Server Charge</span></li>
								</ul>
							</div>
							<ul class="ul-tab-option pc-fb-opt" style="display: none; margin-top: 2px;">
								<li>FEED BOTS: </li>
								<li class="feedbots-opt clk-options li-tab-option active-tab" id="checksum-chart"><span>Checksum</span></li>
								<li data-feedbots="getSuccessStores" class="feedbots-opt clk-options li-tab-option" id="feed-success"><span>Success</span></li>
								<li data-feedbots="getFailedStores" class="feedbots-opt clk-options li-tab-option" id="feed-failed"><span>Fail</span></li>
								<li data-feedbots="getServerChargeStore" class="feedbots-opt clk-options li-tab-option" id="feed-servercharge"><span>Server Charge</span></li>
							</ul>
						</div>
					</div>
						<div class="dropdown-box dbox-hide" style="padding-bottom: 5px;">
							<div class="dropdown-div" style="width: 150px;">
								<div class="select custom-bkgd">
					                <span class="selected-data change-site">Website</span>
					                <span class="pull-right"><i class="fa fa-caret-down" aria-hidden="true"></i></span>
					            </div>
								<ul class="dropdown-menu cos-dropdown-menu">
				                    <li class='opt-site-chk' data-website="aks">AKS</li>
				                    <li class='opt-site-chk' data-website="cdd">CDD</li>
				                    <li class='opt-site-chk' data-website="brexitgbp">BREXITGBP</li>
			                    </ul>
							</div>
							<div class="pull-right">
								<input style="color:#fff;" type="button" name="" class="m-d col-xs-3 btn custom-bkgd" id="btn-getchksumreports" value="TABLE" data-toggle="modal" data-target="#checksum-modal">
							</div>
						</div>
					<div class="card-style dbox-content" style="height: 70%; padding: 5px;">
						<div class="checksum-chart content-hide" style="height: 100%;">
							<canvas id="checksum-4" class="checksum-canvas"></canvas>
						</div>
						<div id="feed-success-append" class="feed-success content-hide" style="height: 100%; overflow-y: auto; display: none;">
							<div><h5 class="text-center mt-2 text-primary" style="font-weight:500; letter-spacing:1.5px;"><span class="s-title"></span>SUCCESS (4 HOURS)</h5></div>

							<div class="col-sm-12 s-buttons" style="display: none;">

							</div>
							<div class="modal-sreports-data col-sm-12">
								<div class="loader-successMdata col-sm-12" style="display: none; height: 500px;"><?php //$this->loader('layouts','loader'); ?></div>
								<div class="modal-reports-data append-sreports padding-lr-10 row">
									
								</div>
							</div>

						</div>
						<div id="feed-failed-append" class="feed-failed content-hide" style="height: 100%; overflow-y: auto; display: none;">
							<div><h5 class="text-center mt-2 text-primary" style="font-weight:500; letter-spacing:1.5px;"><span class="f-title"></span>FAILED STORES (4 HOURS)</h5></div>

							<div class="col-sm-12 f-buttons" style="display: none;">

							</div>
							<div class="modal-freports-data col-sm-12">
								<div class="loader-failedMdata col-sm-12" style="display: none; height: 500px;"><?php //$this->loader('layouts','loader'); ?></div>
								<div class="modal-reports-data append-freports padding-lr-10 row">

								</div>
							</div>
						</div>
						<div id="feed-servercharge-append" class="feed-servercharge content-hide" style="height: 100%; overflow-y: auto; display: none;">
							<div><h5 class="text-center mt-2 text-primary" style="font-weight:500; letter-spacing:1.5px;"><span class="sc-title"></span>Server Charge (Reports)</h5></div>

							<div class="col-sm-12 sc-buttons" style="display: none;">
                
							</div>
							<div class="modal-screports-data col-sm-12">
								<div class="loader-serverchargeMdata col-sm-12" style="display: none; height: 500px;"><?php //$this->loader('layouts','loader'); ?></div>
								<div class="modal-reports-data append-screports padding-lr-10 row">
									
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
