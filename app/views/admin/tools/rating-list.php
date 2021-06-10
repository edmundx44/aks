<?php $this->setSiteTitle($this->pageTitle); ?>
<?php $this->start('head'); ?>
<link rel="stylesheet" href="<?=PROOT?>vendors/css/links-page.css" media="screen" title="no title" charset="utf-8">
<script type="text/javascript">
    const request = { 
        currentDisplay : 0,
        totalRatings: 0,
        merchant : '',
        rating: 101,
        website: 'aks',
        toSearch : '',
    }

    $(function(){
        appendMerchants();

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
            $("#search-rating").val('');
            if($(this).parent()[0].children.length == 3 ){
                request.currentDisplay = 0;
                request.merchant = '';
                request.total = 0;
                request.toSearch = '';
                
				request.website = (indexInput == 0 ) ? inputsSite[0].site : (indexInput == 1 ) ? inputsSite[1].site : (indexInput == 2 ) ? inputsSite[2].site : '';
                setStorage('sessionStorage','website',JSON.stringify(request.website))
                displayRequest(request.rating, '', request.website);
            }
        });

        $(document).on('click', '.select-btn-merchant-di', function(){
            $('.input-search-merchant').val($(this).html())
            request.currentDisplay = 0;
            request.merchant = $(this).attr('data-merchant');
            displayRequest(request.rating, request.merchant, request.website);
        });

        //search merchant in input text
		$(document).on('keyup','.input-search-merchant', function() {
            var typo = regExpEscape(this.value);
			if($(this).closest('div').attr('data-content') == 'Merchant'){
                $('.searchable-ul .name').each(function(){
                    if($(this).html().search(new RegExp(typo, "i")) < 0)
                        $(this).closest('span').fadeOut(500);
                    else 
                       $(this).closest('span').fadeIn(500);
                });
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

    function displayRequest($rating = 101, $merchant = '', $website = 'aks', $offset = 0, $limit = 0, $toSearch = ''){
        $data = {
            action: 'rating-list',
            offset: $offset,
            limit: $limit,
            rating: $rating,
            merchant: $merchant,
            website: $website,
            toSearch: $toSearch
        }
        AjaxCall(url, $data).done(function(data){
            $('#rating-list-display').empty();
            $('#empty-res-data').empty();
            $("#search-rating").val('');
            var result = data.success.data;
            var totalRatingText = 0;
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
            request.currentDisplay = Number(request.currentDisplay) + Number(result.length);
            request.totalRatings = Number(data.success.total);
            totalRatingText = request.currentDisplay+'/'+request.totalRatings;
            }else
                $('#rhyn-tool-display').append('<h4 id="empty-res-data" class="text-center col-sm-12" style="padding:150px;">No Data Found</h4>');
            $('#website-btn').val($website.toUpperCase())
            $(".rating-total-result").html(totalRatingText);
        });
        
    }

    function appendMerchants(){
        AjaxCall(url,$data = {action: 'append-merchants'}).done(function(data){
            $('.select-merchant-div').append('<span class="dropdown-item act-dropdown select-btn-merchant-di name" data-merchant="Default">All</span>')
            for(var i in data){
                let merchant = data[i].vols_nom.substr(0,1).toUpperCase()+data[i].vols_nom.substr(1).toLowerCase();
                $('.select-merchant-div').append('<span class="dropdown-item act-dropdown select-btn-merchant-di name" data-merchant='+data[i].vols_id+'>'+ merchant +' '+data[i].vols_id+'</span>')
            }
        });
    }

</script>
<style>
    .select-merchant-div {
        height: auto;
        max-height: 500px;
        overflow-y: scroll;
        overflow-x: hidden;
    }
    .select-btn-merchant{
        cursor: pointer;
    }
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
                        <div class="col-xs-12 div-body-table mb-2" class="rating-list-containter">
                        
                            <div style="padding: 0 0 35px 0;border:solid 1px transparent;position: relative;">
								<div class="float-left col-3 no-padding">
									<div class="dropdown form-group">
                                        <div class="dropdown-toggle filter-btn" data-content="Merchant" data-toggle="dropdown">
										    <input type="text" class="form-control input-search-merchant bg-warning text-white border-0" placeholder="Select Store">
 
                                        </div>
                                        <div class="dropdown-menu select-merchant-div scrollbar-custom searchable-ul" style="width:100%;">
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

