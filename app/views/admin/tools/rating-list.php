<?php $this->setSiteTitle($this->pageTitle); ?>
<?php $this->start('head'); ?>
<link rel="stylesheet" href="<?=PROOT?>vendors/css/links-page.css" media="screen" title="no title" charset="utf-8">
<script type="text/javascript">
    $(function(){

        var param = getUrlParameter('tab')
        headerTitle(param)
        $('.header-menu-item').removeClass('active-item-menu');
        if(param == ''){
           $('#menu-rating101').addClass('active-item-menu')
        }else{
           $('#menu-'+param).addClass('active-item-menu')
        }
            
    //END 
    });

    function headerTitle(param){
        let title, note;
        switch (param) {
            case 'rating102':
                    title = "Rating 102";
                    note = 'Region forbidden';
                break;
            case 'rating103':
                    title = "Rating 103";
                    note = 'Redirected Link';
                break;
            case 'rating104':
                    title = "Rating 104";
                    note = 'Dead Links';
                break;
            case 'tbaprices':
                    title = "TBA Offers";
                    note = 'Offers with price is equal to 0.02';
                break;
            default:
                title = "Rating 101";
                note = 'Banned offers will not be display in our website';
            break;
        }
        $('.rating-title').text(title);
        $('.rating-note').text(note);
    }
</script>
<?php $this->end(); ?>

<?php $this->start('body')?>
<div class="container-fluid">
    <div class="row">
        <div class="col-lg-12 col-md-12 mtop-35px">
            <div class="card-body rdl-card-main-wrap no-padding">
                <div class="card-div-overflow-style row-1-card-div-overflow-style row-1-card-div-overflow-style-1">
					<p class="card-bulletin header-card-bulitin">MENU :</p>
					<ul class="header-ul-menu">
						<li class="header-menu-item" id="menu-rating101" data-div="rating101"><a href="<?= PROOT.'tools/ratingList?tab=rating101' ?>">Rating 101</a></li>
						<li class="header-menu-item" id="menu-rating102" data-div="rating102"><a href="<?= PROOT.'tools/ratingList?tab=rating102' ?>">Rating 102</a></li>
						<li class="header-menu-item" id="menu-rating103" data-div="rating103"><a href="<?= PROOT.'tools/ratingList?tab=rating103' ?>">Rating 103</a></li>
						<li class="header-menu-item" id="menu-rating104" data-div="rating104"><a href="<?= PROOT.'tools/ratingList?tab=rating104' ?>">Rating 104</a></li>
						<li class="header-menu-item" id="menu-tbaprice" data-div="tbaprice"><a href="<?= PROOT.'tools/ratingList?tab=tbaprices' ?>">TBA Prices</a></li>
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

