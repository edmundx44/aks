<?php $this->setSiteTitle($this->pageTitle); ?>
<?php $this->start('head'); ?>
<link rel="stylesheet" href="<?=PROOT?>vendors/css/links-page.css" media="screen" title="no title" charset="utf-8">
<link rel="stylesheet" href="<?=PROOT?>vendors/css/activities.css" media="screen" title="no title" charset="utf-8">
<script type="text/javascript">
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
                alertMsg('Invalid Entry, Cindly check it carefully.')
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
                    app +=  '<div class="div-inline"><span class="me-text">Edition</span><span class="me-res">'+result[i].edition+'</span></div>';
                    app +=  '<div class="div-inline"><span class="me-text">Region</span><span class="me-res">'+result[i].region+'</span></div>';
                    app +=  '<div><span class="me-res">'+result[i].search_name+'</span></div>';
                    app +=  '<div><span class="me-res"><a class="url-redirect" href='+result[i].buy_url+' target="_blank">'+result[i].buy_url+'</a></span></div>';
                    app += '</div>';
                 $('#rhyn-tool-display').append(app);
            }
        }else
            $('#rhyn-tool-display').append('<h4 id="empty-res-data" class="text-center col-sm-12" style="padding:150px;">No Data Found</h4>');
        $('#website-btn').val(data.success.site.toUpperCase())
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
            <div class="card card-style">
                <div class="card-body rdl-card-main-wrap no-padding">
                    <!-- HEADER STARTS row-4-card-div-overflow-style-->
						<div class="card-div-overflow-style row-4-card-div-overflow-style-2" style="position:relative; padding-top:20px;">
							<div class="row" style="color:#fff;margin: 0;">
								<div class="div-topheader-1 col-lg-10">
									<h5 style="display: inline-block; margin-right: 10px;">Rhyn Tool</h5>
									<p style="font-size:12px;font-weight: 500;">Check using by users</p>
								</div>
                                <div id="website-content" class="col-lg-2" style="padding-bottom:20px;">
                                    <div class="dropdown-title" style="border-radius:5px;">
                                        <input id="website-btn" class="btn input-site website-btn " type="button" value="Website" style="pointer-events: none;">
                                    </div>
                                </div>
                                
							</div>
						</div >
                    <!-- CONTENT STARTS -->
                    <div class="activities-content">
                        <div class="filter-activities">
                            <span class="ac-add-filter"><i class="fas fa-plus-square"></i> &nbsp; <span class="ac-add-filter-span">Add Filter</span></span>
                            <div class="filter-functions">

                                <div class="dropdown filter-function-dd">
                                    <button class="btn btn-primary dropdown-toggle filter-btn" data-toggle="dropdown">
                                        <span class="float-left select-btn-employee">Employee</span>
                                    </button>
                                    <div class="dropdown-menu select-btn-employee-dm scrollbar-custom">
                                        <!-- dynamic data here from database -->
                                     </div>
                                </div>

                                <div class="dropdown filter-function-dd">
                                    <button class="btn btn-primary dropdown-toggle filter-btn" data-toggle="dropdown">
                                        <span class="float-left select-btn-site">Site</span>
                                    </button>
                                    <div class="dropdown-menu select-btn-site-dm">
                                        <span class="dropdown-item act-dropdown select-btn-site-di" data-site="aks">AKS</span>
                                        <span class="dropdown-item act-dropdown select-btn-site-di" data-site="cdd">CDD</span>
                                        <span class="dropdown-item act-dropdown select-btn-site-di" data-site="brexitgbp">BREXIT</span>
                                     </div>
                                </div>

                                <div class="filter-function-dd">
                                    <button class="btn btn-success" id="activities-submit-filter">Submit</button>
                                </div>
                            </div>
                        </div>
                        <div class="col-xs-12 div-body-table mt-4 mb-2" class="ryhn-tool-containter">
							<div class="col-lg-12 no-padding" id="rhyn-tool-display">
								
							</div>
						</div>
                </div>
            </div>
        </div>
    </div>
</div>
<?php $this->end()?>

