<?php $this->setSiteTitle($this->pageTitle); ?>
<?php $this->start('head'); ?>
<link rel="stylesheet" href="<?=PROOT?>vendors/css/links-page.css" media="screen" title="no title" charset="utf-8">
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
								<div class="div-topheader-1 col-lg-10">
									<h5 style="display: inline-block; margin-right: 10px;">Rhyn Tool</h5>
									<p style="font-size:12px;font-weight: 500;">Check using by users</p>
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

