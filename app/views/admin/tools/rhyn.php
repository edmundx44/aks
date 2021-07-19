<?php $this->setSiteTitle($this->pageTitle); ?>

<!-- css -->
<?php $this->start('head'); ?>
	<link rel="stylesheet" href="<?=PROOT?>vendors/css/rhyn.css" media="screen" title="no title" charset="utf-8">
<?php $this->end(); ?>
<!-- css -->

<!-- js -->
<?php $this->start('body-script'); ?>
	<script type="text/javascript" src="<?=PROOT?>vendors/js/rhyn.js"></script>
<?php $this->end(); ?>
<!-- js -->

<?php $this->start('body')?>
<div class="container-fluid">
	<div class="row">
		<div class="col-lg-12 col-md-12 mtop-35px">
			<div class="card card-style">
				<div class="card-body rdl-card-main-wrap no-padding">
					<!-- HEADER STARTS row-4-card-div-overflow-style-->
					<div class="card-div-overflow-style row-4-card-div-overflow-style-2" style="position:relative; padding-top:20px;">
						<div class="row" style="color:#fff;margin: 0;">
							<div class="div-topheader-1 col-lg-12">
								<h5 style="display: inline-block; margin-right: 10px;">Rhyn Tool</h5>
								<p style="font-size:12px;font-weight: 500;">Check, By users</p>
							</div>
						</div >
                    </div>
                    <!-- CONTENT STARTS -->
                    <div class="rhyn-content">
                        <div class="filter-rhyn">
                            <span class="ac-add-filter"><i class="fas fa-plus-square"></i> &nbsp; <span class="ac-add-filter-span">Add Filter</span></span>
                            <div class="filter-functions">

                                <div class="dropdown filter-function-dd">
                                    <button class="btn btn-primary dropdown-toggle filter-btn" data-toggle="dropdown">
                                        <span class="float-left select-btn-employee">Employee</span>
                                    </button>
                                    <div class="dropdown-menu select-btn-employee-dm scrollbar-custom">
                                        <!-- dynamic data here from database -->
                                     </div>
                                </div>

                                <div class="dropdown filter-function-dd">
                                    <button class="btn btn-primary dropdown-toggle filter-btn" data-toggle="dropdown">
                                        <span class="float-left select-btn-site">Site</span>
                                    </button>
                                    <div class="dropdown-menu select-btn-site-dm">
                                        <span class="dropdown-item act-dropdown select-btn-site-di" data-site="aks">AKS</span>
                                        <span class="dropdown-item act-dropdown select-btn-site-di" data-site="cdd">CDD</span>
                                        <span class="dropdown-item act-dropdown select-btn-site-di" data-site="brexitgbp">BREXIT</span>
                                     </div>
                                </div>

                                <div class="filter-function-dd">
                                    <button class="btn btn-success" id="activities-submit-filter">Submit</button>
                                </div>
                            </div>
                        </div>
                        <div class="col-xs-12 div-body-table mt-4 mb-2" class="ryhn-tool-containter">
							<div class="col-lg-12 no-padding" id="rhyn-tool-display">
								
							</div>
						</div>
					</div>
				</div>
			</div>
		</div>
	</div>
</div>
<?php $this->end()?>

