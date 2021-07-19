<?php $this->setSiteTitle($this->pageTitle); ?>

<!-- css -->
<?php $this->start('head'); ?>
	<link rel="stylesheet" href="<?=PROOT?>vendors/css/feed-data.css" media="screen" title="no title" charset="utf-8">
<?php $this->end(); ?>
<!-- css -->

<!-- js -->
<?php $this->start('body-script'); ?>
	<script type="text/javascript" src="<?=PROOT?>vendors/js/feed-data.js"></script>
<?php $this->end(); ?>
<!-- js -->


<?php $this->start('body'); ?>
	<div class="container-fluid">
		<div class="row">
			<div class="col-lg-12 col-md-12 mtop-35px">
				<div class="card card-style card-normalmode">
					<div class="card-body no-padding" style=""> 
						<div class="card-div-overflow-style row-4-card-div-overflow-style-2" style="position:relative; padding-top:20px;">
							<div class="row" style="color:#fff;margin: 0;">
								<div class="header-div col-lg-10">
									<h5 class="header-title-page" style="letter-spacing:1.5px;">Merchant Feed Check</h5>
									<p class="header-text-paragraph">Note: For better searching pls add a correct affiliate link on the respected merchant</p>
								</div>
								<div class="col-lg-2" style="padding-bottom:20px;">
									<div class="col-lg-12">
										<div class="dropdown" style="border-radius:5px; border: 1px solid #418bff;">
											<input id="website-btn" class="btn dropdown-toggle input-site website-btn " type="button" data-toggle="dropdown" value="Website">
											<span class="position-icon-1 text-white"><i class="fas fa-caret-down" ></i></span>
											<div class="dropdown-menu" aria-labelledby="dropdownMenuButton" style="width:100%">
												<div class="dropdown-item website-items" data-website="aks">AKS</div>
												<div class="dropdown-item website-items" data-website="cdd">CDD</div>
												<div class="dropdown-item website-items" data-website="brexitgbp">BREXITGBP</div>
											</div>
										</div>
									</div>
								</div>
							</div>
						</div>
						<div class="me-content-div" style="">
							<div class="row" style="padding: 10px 0;">
								<div class="col-xxl-6 col-xl-3 col-sm-6">
									<div class="dropdown">
										<input type="text" name="" class="input-text-class dropdown-inputbox fd-select-input fd-merchant-selinp" autocomplete='off' style="left: 0;border-left: solid 2px #ccc;border-right: none;padding: 0 5px; border-radius: 5px 0 0 5px;" required>
										<i class="input-text-i fal fa-angle-down"></i>
										<span class="input-text-span fd-si-span" style="left: 5px">Select Merchant</span>
										<span class="input-text-border"></span>

										<div class="dropdown-menu-div fd-dmd-merchant scrollbar-custom" data-dropdown="Merchant">
											<!-- data from database -->
										</div>
									</div>
								</div>
							</div>
						</div>
						<div class="col-lg-12 no-padding array-display mb-4" style="margin-top: 5px;">
							<input type="text" name="" id="test-search" class="form-control" style="width: 100%" placeholder="Search ..." >
							<table id="display-feed-data-table" width="100%" style="font-size: 12px;">
								<!-- data from ajax -->
							</table>     
						</div>
					</div>
				</div>
			</div>
		</div>
	</div>
<?php $this->end();?>