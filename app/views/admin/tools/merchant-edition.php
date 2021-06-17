<?php $this->setSiteTitle($this->pageTitle); ?>
<?php $this->start('head'); ?>
<link rel="stylesheet" href="<?=PROOT?>vendors/css/links-page.css" media="screen" title="no title" charset="utf-8">
<script type="text/javascript" src="https://cdnjs.cloudflare.com/ajax/libs/underscore.js/1.12.0/underscore-min.js"></script>

<script type="text/javascript">
	var $dataReq = {
		action: 'merchant_edition_price_tool',
		website: 'aks',
		merchant: '0',
		edition: '0',
	};

	$(function (){
		var init = safelyParseJSON(getStorage('sessionStorage','website')) 
		if( init && returnSite(init) != null){
			$dataReq.website = init;
			AjaxCall(url, $dataReq).done( ajaxSuccess );
		}else{ removedKeyNormal('sessionStorage','website') 
			AjaxCall(url, $dataReq).done( ajaxSuccess );
		}

		$(document).on('click', '.website-items', function(){
			$('#merchant-edition').empty();
			$('.input-search-merchant, .input-search-edition').val('');
			$dataReq.merchant = '0', $dataReq.edition = '0';
			var indexInput = $(this).parent().prevObject.index();
			if($(this).parent()[0].children.length == 3 ){
				var site = (indexInput == 0 ) ? inputsSite[0].site : (indexInput == 1 ) ? inputsSite[1].site : (indexInput == 2 ) ? inputsSite[2].site : '';
				$dataReq.website = site;
				setStorage('sessionStorage','website',JSON.stringify($dataReq.website))
				AjaxCall(url, $dataReq).done( ajaxSuccess );
			}else{ window.location.reload(); }
		});

		//FOR DROP DOWN SELECT ANIMATION // na na ni sa index.php sa dashboards
		$('.option-click, .option-click-1').click( function() {
			if($(this).attr('data-toggle') == 'Merchant')
				$(this).find('.option-menu-click').slideToggle(200);
			else if($(this).attr('data-toggle') == 'Edition')
				$(this).find('.option-menu-click-1').slideToggle(200);
		});

		//search 
		$(document).on('keyup','.input-search-merchant,.input-search-edition', function() {
			var typo = regExpEscape(this.value);
			if($(this).closest('div').attr('data-content') == 'Merchant'){
				$('.searchable-ul .li-store').each(function(){
					if($(this).text().search(new RegExp(typo, "i")) < 0) $(this).closest('li').fadeOut(500);
					else $(this).closest('li').fadeIn(500);
				});
			}else if($(this).closest('div').attr('data-content') == 'Edition'){
				$('.searchable-ul .li-edition').each(function(){
					if($(this).text().search(new RegExp(typo, "i")) < 0) $(this).closest('li').fadeOut(500);
					else $(this).closest('li').fadeIn(500);
				});
			}
		});
		//click store or edition
		$(document).on('click', '.li-store, .li-edition', function() {
			if($(this).closest('div').attr('data-toggle') == 'Merchant'){
				let $value = $(this).attr('data-name');
				$dataReq.merchant = $(this).attr('data-merId');
				$('.input-search-merchant').val($value);
			}else if($(this).closest('div').attr('data-toggle') == 'Edition'){
				let $value = $(this).attr('data-name');
				$dataReq.edition = $(this).attr('data-ediId');
			$('.input-search-edition').val($value);
			}
		});
	
		$(document).on('click', '#fire', function() {
			$('#merchant-edition').empty();
			AjaxCall(url, $dataReq).done( ajaxSuccess );
		});
	});

	function ajaxSuccess(data) {
		var result = data.success.data;
		for(var i in result){
			var app =  '<div class="result-merchant card-style mb-3">';
				app +=  '<p class="text-note">Create by '+result[i].created_by+' on '+result[i].created_time+'</p>';
				app +=  '<div> <span class="me-text">Merchant</span><span class="me-res">'+result[i].merchant+'</span> </div>';
				app +=  '<div class="div-inline"><span class="me-text">Price</span><span class="me-res">'+result[i].price+'</span></div>';
				app +=  '<div class="div-inline"><span class="me-text">Edition</span><span class="me-res">'+result[i].edition+'</span></div>';
				app +=  '<div class="div-inline"><span class="me-text">Region</span><span class="me-res">'+result[i].region+'</span></div>';
				app +=  '<div><span class="me-res">'+result[i].search_name+'</span></div>';
				app +=  '<div><span class="me-res"><a class="url-redirect aks_color" href='+result[i].buy_url+' target="_blank">'+result[i].buy_url+'</a></span></div>';
				app += '</div>';
			$('#merchant-edition').append(app);
		}
		$('#website-btn').val(data.success.returnWebsite.toUpperCase())
	}
</script>
<?php $this->end(); ?>

<?php $this->start('body')?>
<div class="container-fluid">
    <div class="row">
        <div class="col-lg-12 col-md-12 mtop-35px">
            <div class="card card-style">
                <div class="card-body no-padding">
                    <!-- HEADER STARTS row-4-card-div-overflow-style-->
						<div class="card-div-overflow-style aks_bg_color" style="position:relative; padding-top:20px;">
							<div class="row" style="color:#fff;margin: 0;">
                                <div class="header-div col-lg-10">
									<h5 class="header-title-page">Merchant Edition Check</h5>
									<p class="header-text-paragraph">Check using Merchant and Edition</p>
								</div>
                                <div class="col-lg-2" style="padding-bottom:20px;">
                                    <div class="dropdown" style="border-radius:5px; border: 1px solid #0b5509;">
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
							<div class="col-lg-2" style="padding-bottom:20px;">
								<div class="dropdown-website">
									<div class="selected-website">
										<span class="selected-data"><input id="website-btn" class="website-btn" type="button" value="AKS"></span>
										<span class="position-icon-1"><i class="fas fa-caret-down" ></i></span>
									</div>
									<ul class="merchant-menu-me option-menu-click searchable-ul scrollbar-custom">
                                        <li class='li-store' data-merId="0" data-name="Default">Default</li>
                                        <?php foreach ($this->dataMerchant as $key => $value): ?>     
                                            <li class='li-store' data-merId="<?= trim($key) ?>" data-name="<?= $value ?>"><?="$value $key" ?></li>
                                        <?php endforeach; ?>
									</ul>
								</div>
								<div class="dropdown-edition-me option-click-1 col col-md-3 no-padding" data-toggle="Edition">
									<div class="selected-edition-me div-aks-bgcolor-2" data-content="Edition" style="padding:1px">
                                        <span class="selected-edition"><input type="text" class="input-search-edition form-control" data-search="search" placeholder="Edition"></span>
										<span class="icon-select"><i class="fas fa-caret-down" aria-hidden="true"></i></span>
									</div>
									<ul class="edition-menu-me option-menu-click-1 searchable-ul scrollbar-custom">
                                        <li class='li-edition' data-ediId='0' data-name="Default">Default</li>
                                        <li class='li-edition' data-ediId='1' data-name="Standard">1-Standard</li>
										<li class='li-edition' data-ediId='16' data-name="16-DLC">16-DLC</li>
										<li class='li-edition' data-ediId='7' data-name="7-Deluxe">7-Deluxe</li>
										<li class='li-edition' data-ediId='5' data-name="5-Early Access">5-Early Access</li>
										<li class='li-edition' data-ediId='4' data-name="4-Limited">4-Limited</li>
										<li class='li-edition' data-ediId='33' data-name="33-Preorder bonus">33-Preorder bonus</li>
										<li class="no-hover text-center">*****************************</li>
                                        <?php asort($this->dataEdition);
                                        foreach($this->dataEdition as $key => $value): ?>
                                            <li class='li-edition' data-ediId="<?= trim($key) ?>" data-name="<?= $value ?>"><?="$value $key" ?></li>
                                        <?php   endforeach; ?>
									</ul>
								</div>
								<ul class="merchant-menu-me option-menu-click searchable-ul">
									<li class='li-store' data-merId="0" data-name="Default">Default</li>
									<?php foreach ($this->dataMerchant as $key => $value): ?>     
										<li class='li-store' data-merId="<?= trim($key) ?>" data-name="<?= $value ?>"><?="$value $key" ?></li>
									<?php endforeach; ?>
								</ul>
							</div>
							<div class="dropdown-edition-me option-click-1 col col-md-3 no-padding" data-toggle="Edition">
								<div class="selected-edition-me div-aks-bgcolor-2" data-content="Edition" style="padding:1px">
									<span class="selected-edition"><input type="text" class="input-search-edition form-control" data-search="search" placeholder="Edition"></span>
									<span class="icon-select"><i class="fas fa-caret-down" aria-hidden="true"></i></span>
								</div>
								<ul class="edition-menu-me option-menu-click-1 searchable-ul">
									<li class='li-edition' data-ediId='0' data-name="Default">Default</li>
									<li class='li-edition' data-ediId='1' data-name="Standard">1-Standard</li>
									<li class='li-edition' data-ediId='16' data-name="16-DLC">16-DLC</li>
									<li class='li-edition' data-ediId='7' data-name="7-Deluxe">7-Deluxe</li>
									<li class='li-edition' data-ediId='5' data-name="5-Early Access">5-Early Access</li>
									<li class='li-edition' data-ediId='4' data-name="4-Limited">4-Limited</li>
									<li class='li-edition' data-ediId='33' data-name="33-Preorder bonus">33-Preorder bonus</li>
									<li class="no-hover text-center">*****************************</li>
									<?php asort($this->dataEdition);
										foreach($this->dataEdition as $key => $value): ?>
										<li class='li-edition' data-ediId="<?= trim($key) ?>" data-name="<?= $value ?>"><?="$value $key" ?></li>
									<?php   endforeach; ?>
								</ul>
							</div>
							<input type="button" id="fire" class="button-go btn div-aks-bgcolor-2 text-white" data-search="go" value="Check">
						</div>
					</div>
					<div class="col-xs-12 div-body-table mt-4 mb-2" class="merchant-edition">
						<div class="col-lg-12 no-padding" id="merchant-edition">
								
						</div>
					</div>
				</div>
			</div>
		</div>
	</div>
</div>

<style>
    .result-merchant{
        padding: 4px 10px 4px 10px;
    }
    .me-text{
        /* background-color: #286026;*/  /*green*/
        background-color:#f3f3f3;
        color: #6b6d70;
        border-radius:5px;
        font-weight:500;
        width: 70px;
        display: inline-block;
        margin-right: 5px;
    }
    .text-note{
        margin:0;
        text-decoration:underline;
    }
    .me-text{
        padding-left:2px;
    }
    .me-text,
    .me-res{
        font-size: 12px;
    }
    .me-res{
        font-weight:500;
    }
    .url-redirect{
        word-break: break-all;
    }
    .button-go{
        padding: 8px;
        letter-spacing: 1.5px;
        vertical-align: initial;
    }
    .input-search{
        outline:none;
        border:none;
    }
    .icon-select{
        position: absolute;
        right: 15px;
        top: 12px;
        color: black;
    }
    .searchable-ul{
        max-height: 400px;
    }
    li.no-hover:hover{
        background-color: #fff !important;
    }
    .no-hover{
        pointer-events: none !important;
    }
    .card-style{
        box-shadow: 0 1px 4px 0 rgba(0, 0, 0, 0.40) !important;
    }
    .icon-select{
        top:8px;
    }
</style>
<?php $this->end()?>