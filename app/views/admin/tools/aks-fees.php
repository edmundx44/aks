<?php $this->setSiteTitle($this->pageTitle); ?>
<?php $this->start('head'); ?>
<link rel="stylesheet" href="<?=PROOT?>vendors/css/aks-fees.css" media="screen" title="no title" charset="utf-8">
<script type="text/javascript" src="<?=PROOT?>vendors/js/aks-fees.js"></script>
<?php $this->end() ?>

<?php $this->start('body'); ?>
<div class="container-fluid">
    <div class="row">
        <div class="col-lg-12 col-md-12 mtop-35px">
            <div class="card card-style">
                <div class="card-body rdl-card-main-wrap no-padding">
                    <!-- HEADER STARTS row-4-card-div-overflow-style-->
						<div class="card-div-overflow-style row-4-card-div-overflow-style-2" style="position:relative; padding-top:20px;">
							<div class="row" style="color:#fff;margin: 0;">
								<div class="div-topheader-1 col-lg-10">
									<h5 style="display: inline-block; margin-right: 10px;">Store Fees</h5>
									<p style="font-size:12px;font-weight: 500;">Payment Fees CRUD</p>
								</div>
                                <div class="col-lg-2" style="padding-bottom:20px;">
                                    <div class="">
                                        <div class="selected-website">
                                            <span class="add-span"><input id="add-store-btn" type="button" value="ADD Store" style="border: 1px solid #418bff;"></span>
                                        </div>
                                    </div>
                                </div>                            
							</div>
						</div>
                    <!-- CONTENT STARTS -->
                        <div class="fees-content" style="padding-bottom: 10px;">
                            <div class="fees-content-div fees-merchant-div">
                                <div class="card-body no-padding">
                                    <div class="row" id="append-merchants">
                                        
                                    </div>
                                </div>
                            </div>
                        </div>	

                </div>
            </div>
        </div>
    </div>
</div>

<?php $this->end(); ?>
