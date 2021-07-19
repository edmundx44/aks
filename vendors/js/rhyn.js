$(function(){

        appendUsers(); //populate users

        var init = safelyParseJSON(getStorage('sessionStorage','website')) 
        if( init && returnSite(init) != null){
            AjaxCall(url, $_query = { action : 'rhyn-tool-display', site: init , priceTeam: '' }).done(ajaxSuccess)
		}else{ removedKeyNormal('sessionStorage','website') 
			AjaxCall(url, $_query = { action : 'rhyn-tool-display', site: 'aks', priceTeam: '' }).done(ajaxSuccess)
		}
        
        $(document).on('click', '.ac-add-filter', function(){
            $('.filter-functions').slideToggle('fast');
        });
        //Select employee
        $(document).on('click', '.select-btn-employee-di', function(){
            $('.select-btn-employee').html($(this).html());
            $('.select-btn-employee-remove').remove();
            $('.select-btn-employee-dm').prepend("<span class='dropdown-item act-dropdown select-btn-employee-di select-btn-employee-remove' style='cursor: pointer;pointer-events: none;color: #6b6d70;'>Select Worker</span>");

            $('.select-btn-employee').attr('data-getEmployee', $(this).attr('data-employee'));
        });
        $(document).on('click', '.select-btn-site-di', function(){
            $('.select-btn-site').html($(this).html());
            $('.select-btn-site-remove').remove();
            $('.select-btn-site-dm').prepend("<span class='dropdown-item act-dropdown select-btn-site-di select-btn-site-remove' style='cursor: pointer;pointer-events: none;color: #6b6d70;'>Select Site</span>");
            var indexInput = $(this).parent().prevObject.index();
            if($(this).parent()[0].children.length == 4 ){
				var site = (indexInput == 1 ) ? inputsSite[0].site : (indexInput == 2 ) ? inputsSite[1].site : (indexInput == 3 ) ? inputsSite[2].site : '';
                setStorage('sessionStorage','website',JSON.stringify(site))
                $('.select-btn-site').attr('data-getSite', site)
			}else 
                $('.select-btn-site').attr('data-getSite', 'aks') 
        });
        
        $(document).on('click', '#activities-submit-filter', function(){
            if($('.select-btn-employee').html() == 'Employee' || $(".select-btn-site").html() == 'Site' || $('.select-btn-site').attr('data-getSite') == '')
                alertMsg('Invalid Entry, Cindly check it carefully.', "bg-danger")
            else{
                $priceTeam = $('.select-btn-employee').attr('data-getEmployee');
                $_query = { action : 'rhyn-tool-display', site:  $('.select-btn-site').attr('data-getSite') , priceTeam: $priceTeam }
                AjaxCall(url, $_query).done(ajaxSuccess)
            }
        });

    //END 
    });

    function appendUsers() {
        $_query = { action : 'aks-rhyn-tool', site: 'aks' }
        AjaxCall(url,$_query).done(function(data){
            $('.select-btn-employee-dm').append('<span class="dropdown-item act-dropdown select-btn-employee-di" style="cursor: pointer;" data-employee="">Default</span>')
            for(var i in data){
                let employee = data[i].username.substr(0,1).toUpperCase()+data[i].username.substr(1).toLowerCase();
                $('.select-btn-employee-dm').append('<span class="dropdown-item act-dropdown select-btn-employee-di" style="cursor: pointer;" data-employee='+data[i].username+'>'+ employee +'</span>')
            }
        });
    }

    function ajaxSuccess(data) {
        $('#rhyn-tool-display').empty();
        $('#empty-res-data').empty();
        var result = data.success.data;
        if(result != ''){
            for(var i in result){
                var app =  '<div class="result-merchant card-style mb-3">';
                    app +=  '<p class="text-note">Create by '+result[i].created_by+' on '+result[i].created_time+'</p>';
                    app +=  '<div> <span class="me-text">Merchant</span><span class="me-res">'+result[i].merchant+'</span> </div>';
                    app +=  '<div class="div-inline"><span class="me-text">Price</span><span class="me-res">'+result[i].price+'</span></div>';
                    app +=  '<div class="div-inline"><span class="me-text">Edition</span><span class="me-res">'+result[i].edition_name+'</span></div>';
                    app +=  '<div class="div-inline"><span class="me-text">Region</span><span class="me-res">'+result[i].region_name+'</span></div>';
                    app +=  '<div><span class="me-res">'+result[i].search_name+'</span></div>';
                    app +=  '<div><span class="me-res"><a class="url-redirect" href='+result[i].buy_url+' target="_blank">'+result[i].buy_url+'</a></span></div>';
                    app += '</div>';
                 $('#rhyn-tool-display').append(app);
            }
        }else
            $('#rhyn-tool-display').append('<h4 id="empty-res-data" class="text-center col-sm-12" style="padding:150px;">No Data Found</h4>');
        $('#website-btn').val(data.success.site.toUpperCase())
    }