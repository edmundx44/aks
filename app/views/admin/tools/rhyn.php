<?php $this->setSiteTitle($this->pageTitle); ?>
<?php $this->start('head'); ?>
<link rel="stylesheet" href="<?=PROOT?>vendors/css/utilities-page.css" media="screen" title="no title" charset="utf-8">
<script type="text/javascript">
    $(function(){

        $(document).on('click', '.website-menu', function(){ $(this).find('.dropdown-website').slideToggle(200); });

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
						<div class="card-div-overflow-style aks_bg_color" style="position:relative; padding-top:20px;">
							<div class="row" style="color:#fff;margin: 0;">
								<div class="div-topheader-1 col-lg-9">
									<h5 style="display: inline-block; margin-right: 10px;">Rhyn Tool</h5>
									<p style="font-size:12px;font-weight: 500;">Check using by users</p>
								</div>
                                <div class="website-menu col-lg-3">
                                    <div class="website-btn-div website-card-style">
                                        <input id="website-btn" class="website-btn" type="button" value="AKS">
                                    </div>
                                    <ul class="dropdown-website">
                                        <li class="website-items" data-gsite="aks">AKS</li>
                                        <li class="website-items" data-gsite="cdd">CDD</li>
                                        <li class="website-items" data-gsite="brexitgbp">BREXITGBP</li>
                                    </ul>
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

