<?php $this->setSiteTitle($this->pageTitle); ?>
<?php $this->start('head'); ?>
<link rel="stylesheet" href="<?=PROOT?>vendors/css/utilities-page.css" media="screen" title="no title" charset="utf-8">
<script type="text/javascript">
    $(function(){

        

    //END 
    });

</script>
<?php $this->end(); ?>

<?php $this->start('body')?>
<div class="container-fluid">
    <div class="row">
        <div class="col-lg-12 col-md-12 mtop-35px">
            <div class="card card-style">
                <div class="card-body rdl-card-main-wrap no-padding">
                    <!-- HEADER STARTS row-4-card-div-overflow-style-->
						<div class="card-div-overflow-style row-4-card-div-overflow-style-2" style="position:relative; padding-top:20px;">
							<div class="row" style="color:#fff;margin: 0;">
								<div class="div-topheader-1 col-lg-9">
									<h5 style="display: inline-block; margin-right: 10px;">Rhyn Tool</h5>
									<p style="font-size:12px;font-weight: 500;">Check using by users</p>
								</div>
                                <div class="col-lg-3" style="padding-bottom:20px;">
                                    <div class="dropdown-website">
                                        <div class="selected-website">
                                            <span class="selected-data"><input id="website-btn" class="website-btn" type="button" value="AKS"></span>
                                            <span class="position-icon-1"><i class="fas fa-caret-down" ></i></span>
                                        </div>
                                        <ul class="website-menu" style="display:none;">
                                            <li class='website-items' data-website="aks">AKS</li>
                                            <li class='website-items' data-website="cdd">CDD</li>
                                            <li class='website-items' data-website="brexitgbp">BREXITGBP</li>
                                        </ul>
                                    </div>
                                </div>
                                
							</div>
						</div >
                    <!-- CONTENT STARTS -->
                        <div class="col-xs-12 div-body-table mt-4 mb-2" class="merchant-edition">
							<div class="col-lg-12 no-padding" id="merchant-edition">
								test
							</div>
						</div>
                </div>
            </div>
        </div>
    </div>
</div>
<?php $this->end()?>

