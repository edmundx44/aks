<?php $this->start('head'); ?>

<script src="https://cdn.jsdelivr.net/npm/chart.js@2.8.0"></script>
<script type="text/javascript" src="<?=PROOT?>vendors/js/dashboard-page.js"></script>
<link rel="stylesheet" href="<?=PROOT?>vendors/css/dashboard-page.css" media="screen" title="no title" charset="utf-8">

<style type="text/css">
	.content-darkmode{
		background-color: #1b1b2a;
	}
	.content-normalmode {
		background-color: #fff;
	}
	.sub-content-darkmode{
		background-color: #181825;
	}
	.sub-content-normalmode {
		background-color: #f2f2f2;
	}
	.bulletin-content {
		-webkit-transition: .1s ease-in-out;
		-moz-transition: .1s ease-in-out;
		-o-transition: .1s ease-in-out;
		transition: .1s ease-in-out;
		height: 210px;
		box-shadow: 0 1px 4px 0 rgb(0 0 0 / 14%);
	}
	.bulletin-sub-content {
		-webkit-transition: .1s ease-in-out;
		-moz-transition: .1s ease-in-out;
		-o-transition: .1s ease-in-out;
		transition: .1s ease-in-out;
		height: 50px;
		border-radius: 0 0 5px 5px; 
		padding: 9px;
		position: relative;
	}
	.changelog-content-div {
		padding: 10px 0 10px 0;
		margin-bottom: 10px;
		border-radius: 5px;
		width: 99%;
		box-shadow: inset 0px 0px 15px 2px rgb(107 109 112 / 24%);
	}
	.ccd-header {
		margin: 0 0 0 20px;
		color: #ffa726;
	}
	.ccd-icon {
		font-size: 13px;
	}
	.ccd-name {
		font-size: 15px;
		position: relative;
		top: 1px;
		font-weight: 500;
		letter-spacing: 1px;
	}
	.ccd-date {
		margin: -2px 0 0 20px;
		font-size: 12px;
		color: #ffa726;
	}
</style>
<?php $this->end(); ?>

<?php $this->start('body')?>
<div class="container-fluid">

	<!-- general bulletin section ------------------------------------------ -->
	<div class="row">
		<div class="col-lg-12 col-md-12 mtop-35px">
			<div class="card card-style card-normalmode">
				<div class="card-body no-padding row-1-card-body" style="padding-bottom: 15px !important;"> 
					<div class="card-div-overflow-style row-1-card-div-overflow-style row-1-card-div-overflow-style-1">
						<p class="card-bulletin">General Bulletin</p>
						<p class="card-bulletin-desc">Lorem Ipsum is simply dummy text of the printing and typesetting industry.</p>
					</div>
					<div class="rounded bulletin-content content-normalmode">
						<div style="height: 160px;">
							<div style="float: left; width: 120px;height: 150px;">
								<div style="width: 60px;height: 60px;border-radius: 50px 50px 50px 0;background-image: url('<?=PROOT?>vendors/image/avatar.jpg');background-position: center;background-repeat: no-repeat;background-size: cover;box-shadow: 0 1px 4px 0 rgb(0 0 0 / 54%);margin: 30px auto;">
								</div>
								<p style="margin-top: -20px;width: 120px;text-align: center;	font-size: 	13px;font-weight: 700;letter-spacing: 	1px;"	>Herpaul</p>
							</div>
							<div class="" style="float: left; width: calc(100% - 120px);height: 150px;overflow: hidden;">
								
								<p style="width: 90%;color: #004ea3;font-weight: 700;font-size: 18px;position: relative; top: 20px;left: 20px;">Lorem Ipsum is simply dummy text of the title.</p>
								<p style="font-size: 12px;position: 	relative; top: 3px;left: 20px;">05-02-2021</p>

								<p class="col-xl-7 " style="position: relative;padding: 0 20px 0 20px;font-size: 14px;height: 65px;top: 0;overflow: hidden;">
									It was popularised in the 1960s with the release of Letraset sheets containing Lorem Ipsum passages, and more recently with desktop publishing software like Aldus PageMaker including.<br>
									when an unknown printer took a galley of type and...
								</p>
							</div>

						</div>
						<div class="bulletin-sub-content sub-content-normalmode">
							<p  style="margin-top: 8px;right: 15px;position: absolute; top: 8px;cursor: pointer;	"><i class="fas fa-cog"></i></p>
							<ul style="list-style-type: none;margin-left: 130px;padding: 0;">
								<li style="cursor: pointer;color: #fff;display: inline-block;padding: 6px 15px 6px 15px;border-radius: 20px;font-size: 15px;background-color: #007bff;"><i class="fas fa-comments"></i> &nbsp; <span>16</span></li>
								<li style="cursor: pointer;color: #fff;display: inline-block;padding: 6px 15px 6px 15px;border-radius: 20px;margin-left: 5px; font-size: 15px;background-color: #dc3545;"><i class="fas fa-heart"></i> &nbsp; Liked</li>
							</ul>

							<!-- defaul color if comment 0 if no one like it #61616d -->
						</div>
					</div>
				</div>
			</div>

		</div>
		<!-- <div class="col-lg-6 col-md-12 mtop-50px">
			<div class="card card-style">
				<div class="card-body no-padding row-1-card-body"> 
					<div class="card-div-overflow-style row-1-card-div-overflow-style row-1-card-div-overflow-style-2"> </div>
				</div>
			</div>
		</div> -->
	</div>

	<!-- display report section ---------------------------------------------------------- -->
	<div class="row">
		<div class="col-xxl-6 col-xl-3 col-md-12 mtop-50px">
			<div class="card card-style card-normalmode">
				<div class="card-header no-padding row-2-card-header" style=""> 
					<div class="text-center card-div-overflow-style row-2-card-div-overflow-style row-2-card-div-overflow-style-1">
						<i class="fas fa-ban row-2-icon" ></i>
					</div>
					<p class="card-title-p card-title-p-normal disable-count"></p>
					<p class="card-val-p card-val-p-normal">Disabled</p>
					<p class="card-val-p-sub card-val-p-sub-normal"><span class="disabled-what menu-disabled-what"></span> - SELECTED</p>
				</div>
				<div class="card-body no-padding card-body-style">
					<div class="card-body-div"> 
						<div class="float-right card-body-div-sub">
							<i class="fas fa-eye view-more-icon"  data-to="menu-disabled"> </i> 
							<span class="card-body-div-sub-span" data-to="menu-disabled">view more</span>
						</div>
				
						<i class="fas fa-sliders-h float-left card-body-div-i" data-what="menu-disabled" ></i>
						<div class="card-body-menu-div menu-disabled">
							<ul class="card-body-menu-div-ul">
								<li class="card-body-menu-div-li" data-to="menu-disabled"  data-what="Store"><i class="fas fa-chevron-circle-right" ></i><span class="cbm-span">Store</span></li>
								<li class="card-body-menu-div-li" data-to="menu-disabled"  data-what="Metacritics"><i class="fas fa-chevron-circle-right" ></i><span class="cbm-span">Metacritics</span></li>
							</ul>
						</div>
					</div>
				</div>
			</div>
		</div>
		<div class="col-xxl-6 col-xl-3 col-md-12 mtop-50px">
			<div class="card card-style card-normalmode">
				<div class="card-header no-padding row-2-card-header"> 
					<div class="text-center card-div-overflow-style row-2-card-div-overflow-style row-2-card-div-overflow-style-2">
						<i class="fab fa-snapchat row-2-icon" ></i>
					</div>
					<p class="card-title-p card-title-p-normal snapshot-count"></p>
					<p class="card-val-p card-val-p-normal"> Snapshot</p>
					<p class="card-val-p-sub card-val-p-sub-normal"><span class="snapshot-what menu-snapshot-what"></span> - SELECTED</p>

				</div>
				<div class="card-body no-padding card-body-style">
					<div class="card-body-div"> 
						<div class="float-right card-body-div-sub">
							<i class="fas fa-eye view-more-icon"  data-to="menu-snapshot"> </i> 
							<span class="card-body-div-sub-span" data-to="menu-snapshot">view more</span>
						</div>
						
						<i class="fas fa-sliders-h float-left card-body-div-i" data-what="menu-snapshot" ></i>
						<div class="card-body-menu-div menu-snapshot">
							<ul class="card-body-menu-div-ul">
								<li class="card-body-menu-div-li" data-to="menu-snapshot" data-what="AKS"><i class="fas fa-chevron-circle-right" ></i><span class="cbm-span">AKS</span></li>
								<li class="card-body-menu-div-li" data-to="menu-snapshot" data-what="CDD"><i class="fas fa-chevron-circle-right" ></i><span class="cbm-span">CDD</span></li>
								<li class="card-body-menu-div-li" data-to="menu-snapshot" data-what="BREXIT"><i class="fas fa-chevron-circle-right" ></i><span class="cbm-span">BREXIT</span></li>
							</ul>
						</div>
					</div>
				</div>
			</div>
		</div>
		<div class="col-xxl-6 col-xl-3 col-md-12 mtop-50px">
			<div class="card card-style card-normalmode">
				<div class="card-header no-padding row-2-card-header"> 
					<div class="text-center card-div-overflow-style row-2-card-div-overflow-style row-2-card-div-overflow-style-3">
						<i class="fas fa-database row-2-icon"></i>
					</div>
					
					<p class="card-title-p card-title-p-normal dbfeed-count"></p>
					<p class="card-val-p card-val-p-normal"> DB Feed</p>
					<p class="card-val-p-sub card-val-p-sub-normal"><span class="dbfeed-what menu-dbfeed-what"></span> - SELECTED</p>
				</div>
				<div class="card-body no-padding card-body-style">
					<div class="card-body-div"> 
						<div class="float-right card-body-div-sub">
							<i class="fas fa-eye view-more-icon"  data-to="menu-dbfeed"> </i> 
							<span class="card-body-div-sub-span" data-to="menu-dbfeed">view more</span>
						</div>
						
						<i class="fas fa-sliders-h float-left card-body-div-i" data-what="menu-dbfeed"  ></i>
						<div class="card-body-menu-div menu-dbfeed">
							<ul class="card-body-menu-div-ul">
								<li class="card-body-menu-div-li" data-to="menu-dbfeed" data-what="AKS"><i class="fas fa-chevron-circle-right" ></i><span class="cbm-span">AKS</span></li>
								<li class="card-body-menu-div-li" data-to="menu-dbfeed" data-what="CDD"><i class="fas fa-chevron-circle-right" ></i><span class="cbm-span">CDD</span></li>
								<li class="card-body-menu-div-li" data-to="menu-dbfeed" data-what="BREXIT"><i class="fas fa-chevron-circle-right" ></i><span class="cbm-span">BREXIT</span></li>
							</ul>
						</div>
					</div>
				</div>
			</div>
		</div>
		<div class="col-xxl-6 col-xl-3 col-md-12 mtop-50px">
			<div class="card card-style card-normalmode">
				<div class="card-header no-padding row-2-card-header"> 
					<div class="text-center card-div-overflow-style row-2-card-div-overflow-style row-2-card-div-overflow-style-4">
						<i class="fas fa-random row-2-icon" ></i>
					</div>
					<p class="card-title-p card-title-p-normal">0</p>
					<p class="card-val-p card-val-p-normal">Others</p>
				</div>
				<div class="card-body no-padding card-body-style">
					<div class="card-body-div"> 
						<div class="float-right card-body-div-sub">
							<i class="fas fa-eye view-more-icon" > </i> 
							<span class="card-body-div-sub-span">view more</span>
						</div>
						
						<i class="fas fa-sliders-h float-left card-body-div-i" data-what="menu-others" ></i>
						<div class="card-body-menu-div menu-others">
							<ul class="card-body-menu-div-ul">
								<li class="card-body-menu-div-li"><i class="fas fa-chevron-circle-right" ></i><span class="cbm-span">Others</span></li>
								<li class="card-body-menu-div-li"><i class="fas fa-chevron-circle-right" ></i><span class="cbm-span">Others</span></li>
								<li class="card-body-menu-div-li"><i class="fas fa-chevron-circle-right" ></i><span class="cbm-span">Others</span></li>
							</ul>
						</div>
					</div>
				</div>
			</div>
		</div>
	</div>

	<!-- chart section ---------------------------------------------------------------------------- -->
	<div class="row">
		<div class="col-md-4 mtop-50px">
			<div class="card card-style card-normalmode">
				<div class="card-header no-padding row-3-card-header"> 
					<div class="card-div-overflow-style row-3-card-div-overflow-style row-3-card-div-overflow-style-1 chart-canvas-div"> 
						<canvas id="priceToZeroPercent-1" class="priceToZeroPercent-canvas chart-canvas" height="120"></canvas>
					</div>
					<div class="chart-title-div">
						<p class="chart-title-p">Price to zero</p>
						<div class="chart-title-sub-div">
							<span class="chart-title-sub-div-span">
								<i class="fas fa-long-arrow-alt-up"></i>&nbsp; 
								<span class="chart-title-sub-div-span-1">23</span>
								<span class="chart-title-sub-div-span-2">%</span>
							</span>
							<span class="chart-title-sub-div-span-sub"> product set to price to zero</span>
						</div>
					</div>
				</div>
				<div class="card-body chart-card-body">
					<span class="chart-title-sub-div-span-sub"><i class="far fa-clock"></i><span> updated 9 minutes ago</span></span>
				</div>
			</div>
		</div>
		<div class="col-md-4 mtop-50px">
			<div class="card card-style card-normalmode">
				<div class="card-header no-padding row-3-card-header"> 
					<div class="card-div-overflow-style row-3-card-div-overflow-style row-3-card-div-overflow-style-2 chart-canvas-div">
						<canvas id="realDoubleCounts-1" class="priceToZeroPercent-canvas chart-canvas" height="120"></canvas>
					</div>
					<div class="chart-title-div">
						<p class="chart-title-p">All site count</p>
						<div class="chart-title-sub-div">
							<span class="chart-title-sub-div-span">
								<span class="chart-title-sub-div-span-1">23</span>
							</span>
							<span class="chart-title-sub-div-span-sub"> new double links count</span>
						</div>
					</div>
				</div>
				<div class="card-body chart-card-body">
					<span class="chart-title-sub-div-span-sub"><i class="far fa-clock"></i><span> updated 4 hours ago</span></span>
				</div>
			</div>
		</div>
		<div class="col-md-4 mtop-50px">
			<div class="card card-style card-normalmode">
				<div class="card-header no-padding row-3-card-header"> 
					<div class="card-div-overflow-style row-3-card-div-overflow-style row-3-card-div-overflow-style-3 chart-canvas-div">
						<canvas id="feedBotRuntime-1" class="priceToZeroPercent-canvas chart-canvas" height="120"></canvas>
					</div>
					<div class="chart-title-div">
						<p class="chart-title-p">Feedboot runtime</p>
						<div class="chart-title-sub-div">
							<span class="chart-title-sub-div-span-sub">server issue and reports</span>
						</div>
					</div>
				</div>
				<div class="card-body chart-card-body">
					<span class="chart-title-sub-div-span-sub"><i class="far fa-clock"></i><span> updated 20 days ago</span></span>
				</div>
			</div>
		</div>
	</div>

	<!-- changelog and feedbot section -------------------------------------------- -->
	<div class="row">
		<div class="col-lg-6 col-md-12 mtop-50px">
			<div class="card card-style card-normalmode">
				<div class="card-body no-padding row-4-card-body"> 
					<div class="card-div-overflow-style row-4-card-div-overflow-style row-4-card-div-overflow-style-1 changelog-header-div"> 
						<p class="float-left text-white changelog-header-p">CHANGELOGS</p>
						<button class="float-right btn btn-warning text-white btn-show-add-log-modal" data-toggle="modal" data-target="#show-add-log-modal"><i class="fas fa-plus-square"></i> &nbsp; Create</button>
					</div>
					<div class="scrollbar-custom ccd-con-wrapper">
						
					</div>
				</div>
			</div>
		</div>

		<div class="col-lg-6 col-md-12 mtop-50px">
			<div class="card card-style card-normalmode">
				<div class="card-body no-padding row-4-card-body"> 

					<div class="card-div-overflow-style row-4-card-div-overflow-style row-4-card-div-overflow-style-2 check-width text-white"> 
						<div class="feedbot-menu-div" style="">
							<ul class="ul-tab-option m-fb-opt feedbot-menu-ul">
								<i class="fas fa-sliders-h float-left card-body-div-fb" data-what="menu-feedbots"></i>
								<li class="fb-opt-1">FEED BOTS</li>
							</ul>
							<!-- Mobile view this will be the display-->
							<div class="card-body-menu-div-fbots menu-feedbots">
								<ul class="card-body-menu-div-ul">
									<li id="checksum-chart-m" class="m-feedboot-opt-li" data-m-tab="m-chksum"><i class="fas fa-chevron-circle-right" aria-hidden="true"></i><span class="cbm-span">Checksum</span></li>
									<li id="feed-success-m" class="m-feedboot-opt-li" data-m-tab="m-sStore" data-feedbots="getSuccessStores"><i class="fas fa-chevron-circle-right" aria-hidden="true"></i><span class="cbm-span">Success</span></li>
									<li id="feed-failed-m" class="m-feedboot-opt-li active-tab-1" data-m-tab="m-fStore" data-feedbots="getFailedStores"><i class="fas fa-chevron-circle-right" aria-hidden="true"></i><span class="cbm-span">Fail</span></li>
									<li id="feed-servercharge-m" class="m-feedboot-opt-li" data-m-tab="m-scStorem" data-feedbots="getServerChargeStore"><i class="fas fa-chevron-circle-right" aria-hidden="true"></i><span class="cbm-span">Server Charge</span></li>
								</ul>
							</div>
							<ul class="ul-tab-option pc-fb-opt">
								<li>FEED BOTS: </li>
								<li class="feedbots-opt clk-options li-tab-option" id="checksum-chart"><span>Checksum</span></li>
								<li data-feedbots="getSuccessStores" class="feedbots-opt clk-options li-tab-option" id="feed-success"><span>Success</span></li>
								<li data-feedbots="getFailedStores" class="feedbots-opt clk-options li-tab-option active-tab" id="feed-failed"><span>Fail</span></li>
								<li data-feedbots="getServerChargeStore" class="feedbots-opt clk-options li-tab-option" id="feed-servercharge"><span>Server Charge</span></li>
							</ul>
						</div>
					</div>

					<div class="dropdown-box dbox-hide"><!-- display none first-->
						<div class="dropdown-div feedbot-dd-div">
							<div class="select custom-bkgd">
								<span class="selected-data change-site">Website</span>
								<span class="float-right"><i class="fas fa-caret-down" ></i></span>
							</div>
							<ul class="dropdown-menu cos-dropdown-menu">
								<li class='opt-site-chk' data-website="aks">AKS</li>
								<li class='opt-site-chk' data-website="cdd">CDD</li>
								<li class='opt-site-chk' data-website="brexitgbp">BREXITGBP</li>
							</ul>
						</div>
						<div class="float-right">
							<input type="button" name="" class="m-d col-xs-3 btn custom-bkgd text-white" id="btn-getchksumreports" value="TABLE" data-toggle="modal" data-target="#checksum-modal">
						</div>
					</div>

					<div class="card-style dbox-content">
						<div class="checksum-chart content-hide">
							<canvas id="checksum-4" class="checksum-canvas"></canvas>
						</div>
						<div id="feed-success-append" class="feed-success content-hide">
							<div><h5 class="text-center mt-2 text-primary text-h5-tittle"><span class="s-title"></span>SUCCESS (4 HOURS)</h5></div>

							<div class="col-sm-12 s-buttons">

							</div>
							<div class="modal-sreports-data col-sm-12">
								<div class="loader-successMdata col-sm-12"><?php //$this->loader('layouts','loader'); ?></div>
								<div class="modal-reports-data append-sreports padding-lr-10 row">
									
								</div>
							</div>

						</div>
						<div id="feed-failed-append" class="feed-failed content-hide scrollbar-custom"> <!-- display:none;-->
							<div><h5 class="text-center mt-2 text-primary text-h5-tittle"><span class="f-title"></span>FAILED STORES (4 HOURS)</h5></div>

							<div class="col-sm-12 f-buttons">

							</div>
							<div class="modal-freports-data col-sm-12">
								<div class="loader-failedMdata col-sm-12"><?php //$this->loader('layouts','loader'); ?></div>
								<div class="modal-reports-data append-freports padding-lr-10 row">

								</div>
							</div>
						</div>
						<div id="feed-servercharge-append" class="feed-servercharge content-hide">
							<div><h5 class="text-center mt-2 text-primary text-h5-tittle"><span class="sc-title"></span>Server Charge (Reports)</h5></div>
							<div class="col-sm-12 sc-buttons">
							</div>
							<div class="modal-screports-data col-sm-12">
								<div class="loader-serverchargeMdata col-sm-12"><?php //$this->loader('layouts','loader'); ?></div>
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
