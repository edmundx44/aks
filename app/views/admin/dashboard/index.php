
<?php $this->start('head'); ?>

<script src="https://cdn.jsdelivr.net/npm/chart.js@2.8.0"></script>
<script type="text/javascript" src="<?=PROOT?>vendors/js/dashboard-page.js"></script>

<style type="text/css">
.div-green-dif {
	background-color: #4caf50;
}
.div-yellow-dif {
	background-color: #f6c23e;
}

/*----------------------- SNAPSHOT AKS , CDD DIV  and DBFC --------------------------*/
.vuc{ width: 20%; }
.vdb{ width: 20%; }
.vts,.vds { 
	width: 30%; 
	word-break: break-word;
}
.snapshot-div tbody td,
.snapshot-div thead th {
	padding: 2px 5px 2px 5px !important;
	text-align: center;
	border: solid 1px #d2d2d2 !important;
}
.snap-margin {
	margin-bottom: 5px;
	margin-top: 5px;
}
.snapshot-div{ margin-bottom: 0 !important; }
.report-snapshot-con-wrap,
.report-dbfc-con-wrap {
	padding-left: 20px;
	padding-right: 20px;
	font-size: 12px;
}

.report-snapshot-con-wrap { margin-bottom: 10px; }
.report-snapshot-data-title-div{ 
	padding: 2px 4px 2px 4px; 
	background-color: #edf0f5;
}

.custom-width-th{ width: 45px !important; }

.div-green-dif {
	background-color: #4caf50;
}
.div-yellow-dif {
	background-color: #f6c23e;
}
.div-green-dif,
.div-yellow-dif {
    width: 20%;
    text-align: center;
}
.div-brexitgbp-site,
.div-aks-site,
.div-cdd-site {
	margin-bottom: 10px;
	/*border-radius: 5px;*/
}
.div-aks-site {
	background-color: #4caf50;
}
.div-cdd-site {
	background-color: #f6c23e;
}
.div-brexitgbp-site{
	/*background-color: #00d6f2;*/ /*bot admin gbp color*/
	background-color: rgb(51, 122, 183);
}
.report-dbfc-data-title-div {
	padding: 10px;
	padding-bottom: 0;
}
.report-dbfc-data-title {
	font-size: 13px;
}
.report-dbfc-data {
	padding: 10px;
	padding-top: 0;
}
.btn-dbfc-sites {
	padding-right: 20px; 
	padding-left: 20px;
	position: sticky;
	top: 0;
	border-bottom: 1px solid white;
}
.btn-dbfc-sites {
	display: none;
}
.report-dbfc-con-wrap {
	margin-top: 45px !important; /* First child selector*/
}
.add-margin-top {
	margin-top: 45px;
}

/*card codes start ---------------------------------*/
.card-bulletin {
	position: relative;
	top: 20px; 
	padding-left:20px; 
	padding-right:20px;
	color: #fff;
	letter-spacing: 1px;
}
.card-bulletin-desc{
	position: relative;
	top: 3px; 
	padding-left:20px; 
	padding-right:20px;
	color: #fff;
	font-size: 13px;
}
.card-title-p {
	position: absolute; 
	top:15px;
	right: 15px;
}
.card-val-p {
	position: absolute; 
	top:38px;
	right: 15px;
	font-size: 18px;
	letter-spacing: 1px;
	font-weight: 500;
}
.card-val-p-sub {
	position: absolute; 
	top:65px;
	right: 15px;
	font-size: 15px;
	letter-spacing: 1px;
	font-weight: 500;
}
.card-body-style {
	padding-bottom: 15px !important;
}
.card-body-div {
	width: 100%;
	height:30px;
}
.card-body-div-sub {
	position: relative;	
	top:10px;
	color: #999;
	cursor: pointer;
}
.card-body-div-sub-span {
	font-size: 14px;
	position: relative;	
	top:-1px;
}
.card-body-div-i {
	position: relative;	
	top:11px;
	color: #999;
	font-size: 20px;
	cursor: pointer;
}
.card-body-div-i:hover{
	margin-left: -2px;
	margin-top: -2px;
	font-size: 25px;
	transition: all .1s ease-in-out;
	color: #6b6d70 !important;
}
.card-body-div-fb{
	position: relative;	
	cursor: pointer;
}
.card-body-div-fb:hover{
	margin-left: -4px;
	margin-top: -4px;
	margin-top: -3px;
	font-size: 35px !important;
	transition: all .1s ease-in-out;
}

.card-body-menu-div {
	top: 9px;
	left: 45px;
	width: 150px;
	height: 125px;
	border-radius: 5px;
	background-color: #fff;
	box-shadow: 0 2px 10px 0 rgb(0 0 0 / 26%);
	position: absolute;
	z-index: 1;
	display: none;
}
.card-body-menu-div-fbots {
	top: -81px;
	left: 55px;
	width: 150px;
	height: 135px;
	border-radius: 5px;
	background-color: #fff;
	box-shadow: 0 2px 10px 0 rgb(0 0 0 / 26%);
	position: absolute;
	z-index: 1;
	display: none;
}

.card-body-menu-div:after, 
.card-body-menu-div-fbots:after {
	position: absolute;
    content: "";
    width: 0;
    height: 0;
    bottom: 10px;
    left: 1px;
    box-sizing: border-box;
    border: 5px solid black;
    border-color: transparent transparent #fff #fff;
    transform-origin: 0 0;
    transform: rotate(45deg);
    box-shadow: -1px 1px 3px 0 rgb(0 0 0 / 20%);
}
.card-body-menu-div-ul {
	list-style-type: none;
	padding: 0;
	font-size: 14px;
	position: absolute;
	bottom: -10px;
	width: 100%;

}
.card-body-menu-div-li {
	padding: 5px 5px 5px 15px;
	letter-spacing: 1px;
	font-weight: 700;
	cursor: pointer;
}
.card-body-menu-div-li:hover > .cbm-span {
	text-decoration: underline;
}

.cbm-span {
	margin-left: 5px;
}
/*.cbm-span:hover {
	
}*/
</style>
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
									<li class="card-body-menu-div-li"><i class="fa fa-chevron-circle-right" aria-hidden="true"></i><span class="cbm-span">Checksum</span></li>
									<li class="card-body-menu-div-li"><i class="fa fa-chevron-circle-right" aria-hidden="true"></i><span class="cbm-span">Success</span></li>
									<li class="card-body-menu-div-li"><i class="fa fa-chevron-circle-right" aria-hidden="true"></i><span class="cbm-span">Fail</span></li>
									<li class="card-body-menu-div-li"><i class="fa fa-chevron-circle-right" aria-hidden="true"></i><span class="cbm-span">Server Charge</span></li>
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
								<div class="modal-reports-data append-sreports">
									
								</div>
							</div>

						</div>
						<div id="feed-failed-append" class="feed-failed content-hide" style="height: 100%; overflow-y: auto; display: none;">
							<div><h5 class="text-center mt-2 text-primary" style="font-weight:500; letter-spacing:1.5px;"><span class="f-title"></span>FAILED STORES (4 HOURS)</h5></div>

							<div class="col-sm-12 f-buttons" style="display: none;">

							</div>
							<div class="modal-freports-data col-sm-12">
								<div class="loader-failedMdata col-sm-12" style="display: none; height: 500px;"><?php //$this->loader('layouts','loader'); ?></div>
								<div class="modal-reports-data append-freports">

								</div>
							</div>
						</div>
						<div id="feed-servercharge-append" class="feed-servercharge content-hide" style="height: 100%; overflow-y: auto; display: none;">
							<div><h5 class="text-center mt-2 text-primary" style="font-weight:500; letter-spacing:1.5px;"><span class="sc-title"></span>Server Charge (Reports)</h5></div>

							<div class="col-sm-12 sc-buttons" style="display: none;">
                
							</div>
							<div class="modal-screports-data col-sm-12">
								<div class="loader-serverchargeMdata col-sm-12" style="display: none; height: 500px;"><?php //$this->loader('layouts','loader'); ?></div>
								<div class="modal-reports-data append-screports">
									
								</div>
							</div>

						</div>
					</div>

				</div>
			</div>
		</div>
	</div>
</div>

<style type="text/css">

.m-fb-opt i:nth-child(1){
	color: #fff;
	font-size: 30px;
	padding: 5px 0 0 10px;
}
.m-fb-opt .fb-opt-1{
	font-size: 20px !important;
	padding: 7px;
	margin-left: 10px;
	font-weight: 500;
}

.ul-tab-option {
	font-size: 13px;
	list-style-type: none; 
	margin: 0;
	padding: 0;
}
.ul-tab-option li {
	border-radius: 5px;
    display: inline-block;
    padding: 10px;
    /*padding: 5px 10px 5px 10px;*/
}
.active-tab {
    background-color: rgba(255, 255, 255, .2);
    color: #fff;
    /*color: #004ea3;*/
}
.li-tab-option{
	border: none;
	font-weight: 600;
	cursor: pointer;
}
.li-tab-option:hover{
	background-color: rgba(255, 255, 255, .2);
	color: #fff;

	-webkit-transition: .4s ease-in-out;
    -moz-transition: .4s ease-in-out;
    -o-transition: .4s ease-in-out;
    transition: .4s background-color ease-in-out ;
}


.dropdown-menu{
	min-width: 150px;
}

.dropdown-div {
  width: 100%;
  display: inline-block;
  background-color: #fff;
  border-radius: 2px;
  box-shadow: 0 0 2px rgb(204, 204, 204);
  transition: all .5s ease;
  position: relative;
  font-size: 14px;
  color: #474747;
  height: 100%;
  text-align: left;
  z-index: 999;
}
.dropdown-div .select {
    cursor: pointer;
    display: block;
    padding: 10px;
    background-color: #3f51b5;
    color: #fff;
}
.dropdown-div .select > i {
    font-size: 13px;
    color: #fff;
    cursor: pointer;
    transition: all .3s ease-in-out;
    float: right;
    line-height: 20px
}
.dropdown-div:hover {
    box-shadow: 0 0 4px rgb(204, 204, 204)
}
.dropdown-div:active {
    background-color: #f8f8f8
}
.dropdown-div .dropdown-menu {
    position: absolute;
    background-color: #fff;
    width: 100%;
    left: 0;
    margin-top: 1px;
    box-shadow: 0 1px 2px rgb(204, 204, 204);
    border-radius: 0 1px 2px 2px;
    overflow: hidden;
    display: none;
    overflow-y: auto;
    z-index: 9
}
.dropdown-div .dropdown-menu li {
    padding: 10px;
    transition: all .2s ease-in-out;
    cursor: pointer
} 
.dropdown-div .dropdown-menu {
    padding: 0;
    list-style: none
}
.dropdown-div .dropdown-menu li:hover {
    background-color: #f2f2f2
}
.dropdown-div .dropdown-menu li:active {
    background-color: #e2e2e2
}
.custom-bkgd{
	border-radius: 5px;
	background: linear-gradient(60deg, #004ea3, #0062cc);
	font-weight: bold;
}
.cos-dropdown-menu li:hover{
	background: linear-gradient(60deg, #004ea3, #0062cc);
	color: white;
	font-weight: bold;

	-webkit-transition: .4s ease-in-out;
    -moz-transition: .4s ease-in-out;
    -o-transition: .4s ease-in-out;
    transition: .4s background-color ease-in-out ;
}


/*-----     Modal TABLE */
.modal-con-override {
    background-color: #edf0f5;
}
.modal-checksum-data table thead tr {
    border: solid 1px #fff;
}
.modal-checksum-data table thead tr th{
    background-color: #fff;
}
.modal-checksum-data th:nth-child(1) {
    width: 25%; /*set width of 1st child*/
}
.table thead th,
.table td{
	border: none; /*remove border default of modal*/
	padding: 8px;
}
.table thead th{
	color: #0062cc;
}
.modal-checksum-data tbody .tbody-td-1,
.modal-checksum-data tbody .tbody-td-2,
.modal-checksum-data tbody .tbody-td-3 {
	border:solid 1px #fff;
}
.modal-checksum-data tbody .tbody-td-2 {
	word-break: break-all;
	width: 150px;
}
.modal-checksum-data tbody .tbody-td-3 {
	width: 100px;
}

</style>


<?php $this->end()?>
