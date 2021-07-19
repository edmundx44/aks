const request = { 
        currentDisplay : 0,
        totalRatings: 0,
        merchant : '',
        rating: 101,
        website: 'aks'
    }

    $(function(){
        appendMerchants();

        var param = getUrlParameter('tab');
        headerTitle(param);
        $('.header-menu-item').removeClass('active-item-menu');
        var initSite = safelyParseJSON(getStorage('sessionStorage','website'));
        
        if(param == '') $('#menu-rating101').addClass('active-item-menu')
        else $('#menu-'+param).addClass('active-item-menu')

        if( initSite && returnSite(initSite) != null){
            request.website = initSite;
            var $initData = checkRequest(request.rating, '', request.website);
            ($initData != null) ?  displayRequest($initData) : alertMsg('Please Reload the page..', "bg-danger");
		}else{ 
            removedKeyNormal('sessionStorage','website')
            var $initData = checkRequest(request.rating, '', 'aks');
            ($initData != null) ?  displayRequest($initData) : alertMsg('Please Reload the page..', "bg-danger");
		}
        
        //select website
        $(document).on('click', '.website-items', function(){
            var indexInput = $(this).parent().prevObject.index();
            $("#search-rating").val('');
            $('#rating-list-display').empty();
            if($(this).parent()[0].children.length == 3 ){
                request.currentDisplay = 0;
                request.merchant = '';
                request.total = 0;
                
				request.website = (indexInput == 0 ) ? inputsSite[0].site : (indexInput == 1 ) ? inputsSite[1].site : (indexInput == 2 ) ? inputsSite[2].site : '';
                setStorage('sessionStorage','website',JSON.stringify(request.website))
                var $data = checkRequest(request.rating, '', request.website);
                ($data != null) ? displayRequest($data) : alertMsg('Please Reload the page..', "bg-danger");
            }
            
        });

        //select merchant
        $(document).on('click', '.select-btn-merchant-di', function(){
            $('.input-search-merchant').val($(this).html())
            $('#rating-list-display').empty();
            $("#search-rating").val('');

            request.currentDisplay = 0;
            request.merchant = $(this).attr('data-merchant');

            var $data = checkRequest(request.rating, request.merchant, request.website);
            ($data != null) ? displayRequest($data) : alertMsg('Please Reload the page..', "bg-danger");
        });

        //laod more
        $(document).on('click', '.lmore-function', function lmore(data) {
            var $datalmore = checkRequest(request.rating, request.merchant, request.website, request.currentDisplay);
            if(request.currentDisplay != request.totalRatings && request.currentDisplay < request.totalRatings)
                ($datalmore != null) ? displayRequest($datalmore) : alertMsg('Please Reload the page..', "bg-danger");
        });

        //search merchant in input text
		$(document).on('keyup','.input-search-merchant', function() {
            var typo = regExpEscape(this.value);
			if($(this).closest('div').attr('data-content') == 'Merchant'){
                $('.searchable-ul .name').each(function(){
                    ($(this).html().search(new RegExp(typo, "i")) < 0) ? $(this).closest('span').fadeOut(500) : $(this).closest('span').fadeIn(500);                       
                });
            }
        });

        $(document).on('focusout', '#search-rating', function(){   
            var $search = this.value;
            request.currentDisplay = 0;
            request.totalRatings = 0;
            request.merchant = '';
            $data = { action: "search-rating-list", toSearch: $search, rating: request.rating, website: request.website };
            if($search.length >= 5) {
                $('#rating-list-display').empty();  
                AjaxCall(url, $data).done(appendResultDiv) 
            }else
                alertMsg("Atleast 5 characters", "bg-danger") ;            
        });
        //search url in datatable
        $('#search-rating').keypress(function(e){
			if(e.which == 13)
                $(this).blur();
		});

    //END 
    });

    function checkRequest($rating = 101, $merchant = '', $website = 'aks', $offset = 0){
        $data = {
            action: 'rating-list',
            offset: $offset,
            rating: $rating,
            merchant: $merchant,
            website: $website
        }
        if( [101,102,103,104,'tba'].includes($data.rating) && 
            ['aks','cdd','brexitgbp'].includes($data.website) &&
            $data.offset >= 0 )
            return $data;
        return null;
    }

    function displayRequest($data){
        AjaxCall(url, $data).done(appendResultDiv)
    }

    function appendResultDiv(data){
        $('#empty-res-data').empty();
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
            request.currentDisplay = parseInt(request.currentDisplay) + parseInt(result.length);
            request.totalRatings = parseInt(data.success.total);
            totalRatingText = request.currentDisplay+'/'+request.totalRatings;
        }else
            $('#rating-list-display').append('<h4 id="empty-res-data" class="text-center col-sm-12" style="padding:150px;">No Data Found</h4>');
        $('#website-btn').val($data.website.toUpperCase());
        $(".rating-total-result").html(totalRatingText);
        (totalRatingText != 0 && request.currentDisplay != request.totalRatings) ? $('#lmore-div').show() : $('#lmore-div').hide();        
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
                    request.rating = 'tba';
                    note = 'Offers with price is equal to 0.02 based on the release date of the game thats equals to this month';
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