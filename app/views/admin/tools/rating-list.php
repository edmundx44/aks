<?php $this->setSiteTitle($this->pageTitle); ?>
<?php $this->start('head'); ?>
<link rel="stylesheet" href="<?=PROOT?>vendors/css/links-page.css" media="screen" title="no title" charset="utf-8">
<script type="text/javascript">
    const request = { 
        currentDisplay : 0,
        merchant : '',
        total : '',
        rating: 101,
        website: 'aks',
        toSearch : '',
    }

    $(function(){
        var param = getUrlParameter('tab');
        headerTitle(param);
        $('.header-menu-item').removeClass('active-item-menu');
        var init = safelyParseJSON(getStorage('sessionStorage','website'));
        
        if(param == '') $('#menu-rating101').addClass('active-item-menu')
        else $('#menu-'+param).addClass('active-item-menu')

        if( init && returnSite(init) != null){
            request.website = init;
            displayRequest(request.rating, '', request.website);
		}else{ removedKeyNormal('sessionStorage','website') 
			displayRequest(request.rating, '', 'aks');
		}
        
        $(document).on('click', '.website-items', function(){
            var indexInput = $(this).parent().prevObject.index();
            if($(this).parent()[0].children.length == 3 ){
                request.currentDisplay = 0;
                request.merchant = '';
                request.total = '';
                request.toSearch = '';

				request.website = (indexInput == 0 ) ? inputsSite[0].site : (indexInput == 1 ) ? inputsSite[1].site : (indexInput == 2 ) ? inputsSite[2].site : '';
                setStorage('sessionStorage','website',JSON.stringify(request.website))
                displayRequest(request.rating, '', request.website);
            }
        });



    //END 
    });

    function headerTitle(param){
        let title, note;
        switch (param) {
            case 'rating102':
                    title = "Rating 102";
                    note = 'Region forbidden';
                    request.rating = 102;
                break;
            case 'rating103':
                    title = "Rating 103";
                    note = 'Redirected Link';
                    request.rating = 103;
                break;
            case 'rating104':
                    title = "Rating 104";
                    note = 'Dead Links';
                    request.rating = 104;
                break;
            case 'tbaprices':
                    title = "TBA Offers";
                    note = 'Offers with price is equal to 0.02';
                break;
            default:
                title = "Rating 101";
                request.rating = 101;
                note = 'Banned offers will not be display in our website';
            break;
        }
        $('.rating-title').text(title);
        $('.rating-note').text(note);
    }

    function displayRequest($rating = 101, $merchant = '', $website = 'aks', $offset = 0, $limit = 0, $total = 0){
        $data = {
            action: 'rating-list',
            offset: $offset,
            limit: $limit,
            total: $total,
            rating: $rating,
            merchant: $merchant,
            website: $website,
        }
        AjaxCall(url, $data).done(function(data){
            $('#rating-list-display').empty();
            $('#empty-res-data').empty();
            var result = data.success.data;
            if(result != ''){
                for(var i in result){
                    var app =  '<div class="result-merchant card-style mb-3">';
                        app +=  '<p class="text-note">Create on '+result[i].created_time+'</p>';
                        app +=  '<div> <span class="me-text">Merchant</span><span class="me-res">'+result[i].merchant+'</span> </div>';
                        app +=  '<div class="div-inline"><span class="me-text">Price</span><span class="me-res">'+result[i].price+'</span></div>';
                        app +=  '<div class="div-inline"><span class="me-text">Edition</span><span class="me-res">'+result[i].edition+'</span></div>';
                        app +=  '<div class="div-inline"><span class="me-text">Region</span><span class="me-res">'+result[i].region+'</span></div>';
                        app +=  '<div><span class="me-res">'+result[i].search_name+'</span></div>';
                        app +=  '<div><span class="me-res"><a class="url-redirect" href='+result[i].buy_url+' target="_blank">'+result[i].buy_url+'</a></span></div>';
                        app += '</div>';
                    $('#rating-list-display').append(app);
                }
            request.currentDisplay = Number(request.currentDisplay) + Number(data.success.total);
            }else
                $('#rhyn-tool-display').append('<h4 id="empty-res-data" class="text-center col-sm-12" style="padding:150px;">No Data Found</h4>');
            $('#website-btn').val($website.toUpperCase())
            $("#total-ratings").html(request.currentDisplay);
        });
        
    }


</script>
<style>
    .result-merchant{
        padding: 4px 10px 4px 10px;
    }
    .me-text{
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
</style>
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
                        <div class="col-xs-12 div-body-table mt-2 mb-2" class="rating-list-containter">
                            <div class="col-lg-12 no-padding mb-3" id="search">
                                    <input type="text" class="form-control col-lg-6" placeholder="Search Link">
                                    <div class="total-div col-lg-6">
                                        Total Result: <span id="total-ratings"></span>
                                    </div>
                            </div>
							<div class="col-lg-12 no-padding" id="rating-list-display">
								
							</div>
                            <div class="col-lg-12 text-center" style="padding:10px;">
                                <span class="data-display-function lmore-fucntion"> 
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

