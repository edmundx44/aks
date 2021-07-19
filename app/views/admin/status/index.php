<?php $this->setSiteTitle("Status Controller"); ?>

<?php $this->start('head'); ?>
	<link rel="stylesheet" href="<?=PROOT?>vendors/css/links-page.css" media="screen" title="no title" charset="utf-8">
	<link rel="stylesheet" href="<?=PROOT?>vendors/css/status-controller.css" media="screen" title="no title" charset="utf-8">
<?php $this->end(); ?>

<?php $this->start('body-script'); ?>
	<script type="text/javascript" src="<?=PROOT?>vendors/js/status-controller.js"></script>
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
					<div class="card-div-overflow-style text-dark" style="position:relative;margin-top:5px;margin-bottom:5px; ">
						<div class="row" style="margin: 0;padding-top: 10px;padding-bottom: 10px;">
							<div class="div-topheader-1 col-lg-10 pad-lr-20">
								<p class="rating-title">Note: By setting the button to OFF it will be disabled all offers and will not be displayed in website and vice versa</p>
							</div>
							<div class="col-lg-2 div-site-hide" style="display:none">
								<div class="dropdown row-4-card-div-overflow-style-2" style="border-radius:5px;">
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
					<div class="sc-content" style="padding-bottom: 10px;">
						<div class="sc-content-div sc-merchant-div">
							<div class="card-body no-padding">
								<div class="row append-merchants">

								</div>
							</div>
						</div>
						<div class="sc-content-div sc-metacritics-div" style="display: none;">
							<div class="card-body no-padding">
								<div class="row append-critics">
								
								</div>
							</div>
						</div>
					</div>	
				</div>	
			</div>
		</div>
	</div>
<?php $this->end()?>
