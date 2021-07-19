<?php $this->setSiteTitle("Double Links"); ?>

<!-- css -->
<?php $this->start('head'); ?>
	<link rel="stylesheet" href="<?=PROOT?>vendors/css/double-links.css" media="screen" title="no title" charset="utf-8">
<?php $this->end(); ?>
<!-- css -->

<!-- js -->
<?php $this->start('body-script'); ?>
	<script type="text/javascript" src="<?=PROOT?>vendors/js/double-links.js"></script> 
<?php $this->end(); ?>
<!-- js -->

<?php $this->start('body')?>
	<div class="container-fluid">
		<div class="row">
			<div class="col-lg-12 col-md-12 mtop-35px">
				<div class="card card-style card-normalmode">
					<div class="card-body no-padding"> 
						<div class="card-div-overflow-style row-1-card-div-overflow-style row-1-card-div-overflow-style-1">
							<p class="card-bulletin dl-card-bulitin">MENU :</p>
							<div class="d-xl-none" style="position: absolute; top: 20px;right: 20px; color: #fff;cursor: pointer;font-size: 18px;"><i class="fal fa-bars"></i></div>

							<div class="dropdown d-xl-block dl-dd-site" style="display: none;position: absolute;top: 12.5px;right: 12.5px;">
								<button class="btn btn-primary dropdown-toggle" data-toggle="dropdown" style="width: 150px;">
									<span class="float-left dl-dd-site-span">Select Site</span>
								</button>
								<div class="dropdown-menu">
									<span class="dropdown-item dl-dd-site-di" data-whatni="aks">AKS</span>
									<span class="dropdown-item dl-dd-site-di" data-whatni="cdd">CDD</span>
									<span class="dropdown-item dl-dd-site-di" data-whatni="brex">BREX</span>
								</div>
							</div>

							<ul class="dl-cb-ul-menu d-xl-block" style="display: none;">
								<li class="dl-li-btn active-dl-menu" id="dl-real-double-div">Real Double</li>
								<li class="dl-li-btn" id="dl-suspicious-double-div">Suspicious Double</li>
								<li class="dl-li-btn" id="dl-metacritics-double-div">Metacritics Double</li>
							</ul>
						</div>
					</div>
					<div class="dl-content" style="padding-bottom: 10px;">
						<div class="dl-content-div dl-real-double-div">
							<div style="padding: 0 0 35px 0;">
								<div class="bg-warning text-white rounded text-center float-left" style="width: 200px;padding: 7px;">Total Result's  &nbsp; : &nbsp; 
									<b>
										<span class="total-result">0</span>
									</b>
								</div>
								<button class="btn btn-warning float-right text-white" id="rd-delete-selected" style="width: 200px;padding: 7px;">Delete Selected</button>
							</div>

							<table class="col-12" style="margin: 20px 0 0 0;">
								<div class="dl-rddc-loader" style="display:none;">
									<?php include ROOT. DS . 'app' . DS . 'views' . DS . 'layouts' . DS. 'processing-loader.php'; ?>
								</div>

								<thead>
									<tr class="" style="color: #fff;background-color: #007bff;">
										<th class="hide-on-smmd" style="padding: 10px;width: 45%;">Link</th>
										<th class="" style="padding: 10px;width: 10%;">Price</th>
										<th class="" style="padding: 10px;width: 10%;;">Stock</th>
										<th class="" style="padding: 10px;width: 35%;text-align:center;">Action</th>
									</tr> 
								</thead>
								<tbody id="dl-real-double-display-content-div">
									<!-- dynamic data here from database -->
								</tbody>
							</table>
						</div>

						<div class="dl-content-div dl-suspicious-double-div" style="display: none;position: relative;">
							<div style="padding: 0 0 35px 0;border:solid 1px transparent;position: relative;">
								<div class="float-left" style="">
									<div class="form-group">
										<input type="text" class="form-control sd-select-store-name bg-warning text-white border-0 " list="stores-data" placeholder="Select Store" data-getstoreid="">
									</div>
									<datalist id="stores-data" class="stores-data-class">
										<!-- dynamic data here from database -->
									</datalist>
								</div>
								<div class="bg-warning float-right rounded text-center text-white" style="width: 200px;padding: 7px;">
									Total Result's  &nbsp; : &nbsp; 
									<b>
										<span class="sdl-total-result"></span>
									</b>
								</div>
							</div>

							<div class="display-suspicious-double-loader" style="display:none;">
								<?php include ROOT. DS . 'app' . DS . 'views' . DS . 'layouts' . DS. 'processing-loader.php'; ?>
							</div>

							<div class="display-suspicious-double-div" style="margin: 15px 0 0 0;border:solid 1px transparent;">
								<!-- dynamic data here from database -->
							</div>
							<div class="text-center dl-sl-div" style="display:none;">
								<button class="btn btn-primary dl-sl-loadmore-btn"><i class="fas fa-spinner"></i> Load More</button>
								<button class="btn btn-primary dl-sl-displayall-btn"><i class="fas fa-globe"></i> Display All</button>
							</div>
						</div>

						<div class="dl-content-div dl-metacritics-double-div" style="display: none;">
							Metacritics Double
						</div>
					</div>	
				</div>	
			</div>
		</div>
	</div>
<?php $this->end()?>
