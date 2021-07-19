<?php $this->setSiteTitle($this->pageTitle); ?>

<?php $this->start('head'); ?>
    <link rel="stylesheet" href="<?=PROOT?>vendors/css/links-page.css" media="screen" title="no title" charset="utf-8">
    <link rel="stylesheet" href="<?=PROOT?>vendors/css/rating-list.css" media="screen" title="no title" charset="utf-8">
<?php $this->end(); ?>

<?php $this->start('body-script'); ?>
    <script type="text/javascript" src="<?=PROOT?>vendors/js/rating-list.js"></script>
<?php $this->end(); ?>

<?php $this->start('body')?>
	<div class="container-fluid">
		<div class="row">
			<div class="col-lg-12 col-md-12 mtop-35px">
				<div class="card-body rdl-card-main-wrap no-padding">
					<div class="card-div-overflow-style row-1-card-div-overflow-style row-1-card-div-overflow-style-1">
						<p class="card-bulletin header-card-bulitin">MENU :</p>
						<ul class="header-ul-menu">
							<li class="header-menu-item" id="menu-rating101" data-div="rating101"><a class ="a-style" href="<?= PROOT.'tools/ratingList?tab=rating101' ?>">Rating 101</a></li>
							<li class="header-menu-item" id="menu-rating102" data-div="rating102"><a class ="a-style" href="<?= PROOT.'tools/ratingList?tab=rating102' ?>">Rating 102</a></li>
							<li class="header-menu-item" id="menu-rating103" data-div="rating103"><a class ="a-style" href="<?= PROOT.'tools/ratingList?tab=rating103' ?>">Rating 103</a></li>
							<li class="header-menu-item" id="menu-rating104" data-div="rating104"><a class ="a-style" href="<?= PROOT.'tools/ratingList?tab=rating104' ?>">Rating 104</a></li>
							<li class="header-menu-item" id="menu-tbaprices" data-div="tbaprices"><a   class ="a-style" href="<?= PROOT.'tools/ratingList?tab=tbaprices' ?>">TBA Prices</a></li>
						</ul>
					</div>
				</div>
			</div>
		</div>
	</div>

	<div class="container-fluid">
	    <div class="row">
	        <div class="col-lg-12 col-md-12 mtop-35px">
	            <div class="card card-style">
	                <div class="card-body rdl-card-main-wrap no-padding">
	                    <!-- HEADER STARTS row-4-card-div-overflow-style-->
							<div class="card-div-overflow-style row-4-card-div-overflow-style-2" style="position:relative; padding-top:20px;">
								<div class="row" style="color:#fff;margin: 0;">
									<div class="div-topheader-1 col-lg-10">
										<h5 class="rating-title" style="display: inline-block; margin-right: 10px;"></h5>
	                                    <p class="rating-note" style="font-size:12px;font-weight: 500;"></p>
									</div>
	                                <div class="col-lg-2" style="padding-bottom:20px;">
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
	                    <!-- CONTENT STARTS -->
	                        <div class="col-xs-12 div-body-table mb-2" class="rating-list-containter">
	                        
	                            <div style="padding: 0 0 35px 0;border:solid 1px transparent;position: relative;">
									<div class="float-left col-3 no-padding">
										<div class="dropdown form-group">
	                                        <div class="dropdown-toggle filter-btn" data-content="Merchant" data-toggle="dropdown">
											    <input type="text" class="form-control input-search-merchant bg-warning text-white border-0" placeholder="Select Store">
	 
	                                        </div>
	                                        <div class="dropdown-menu select-merchant-div scrollbar-custom searchable-ul" style="width:100%; position:relative">
	                                                <!-- dynamic data here from database -->
	                                        </div>
										</div>

									</div>
									<div class="bg-warning float-right rounded text-center text-white" style="width: 200px;padding: 7px;">
										Total Result's  &nbsp; : &nbsp; 
										<b>
											<span class="rating-total-result"></span>
										</b>
									</div>
								</div>

	                            <div class="col-lg-12 no-padding mb-2" id="search"><input id="search-rating" type="text" class="form-control" placeholder="Search Link"></div>
								<div class="col-lg-12 no-padding" id="rating-list-display"></div>
	                            <div id="lmore-div" class="col-lg-12 text-center" style="padding:10px;display:none;">
	                                <span class="data-display-function lmore-function"> 
										<i class="fas fa-spinner"></i> Load More 
									</span>
	                            </div>
							</div>

					</div>
				</div>
			</div>
		</div>
	</div>

<?php $this->end()?>

