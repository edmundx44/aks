<?php $this->setSiteTitle($this->pageTitle); ?>

<?php $this->start('head'); ?>
	<link rel="stylesheet" href="<?=PROOT?>vendors/css/merchant-edition.css" media="screen" title="no title" charset="utf-8">
<?php $this->end(); ?>

<?php $this->start('body-script'); ?>
	<script type="text/javascript" src="<?=PROOT?>vendors/js/merchant-edition.js"></script>
<?php $this->end(); ?>


<?php $this->start('body')?>
	<div class="container-fluid">
		<div class="row">
			<div class="col-lg-12 col-md-12 mtop-35px">
				<div class="card card-style card-normalmode">
					<div class="card-body no-padding" style=""> 
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
							</div>
						</div>
						<div class="me-content-div" style="">
							<div class="row" style="padding: 10px 0;">
								<div class="col-xxl-6 col-xl-3 col-sm-6">
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
								<div class="col-xxl-6 col-xl-3 col-sm-6">
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

