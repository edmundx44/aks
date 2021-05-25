<?php $this->setSiteTitle($this->pageTitle); ?>
<?php $this->start('head'); ?>
<link rel="stylesheet" href="<?=PROOT?>vendors/css/utilities-page.css" media="screen" title="no title" charset="utf-8">

<script type="text/javascript">
    var $_query = { user:null , action: 'recent-activity', website:'aks', useraction: 'created' };
    var $url = '<?=PROOT?>activities/act';

    $(function(){
        setActiveTab(getUrlParameter('tab'));

        $(document).on('click', '.header-menu-item', function(){
            var $target = $(this).attr('data-div');

            $('.header-menu-item').removeClass('active-item-menu');
            $(this).addClass('active-item-menu');
            $('.act-content').hide();
            $('#'+ $target).show();

            switch ($target) {
                case 'recent-activity':
                    var param = '';
                    getUsersItems();
                    AjaxCall($url,$_query).done( recentActAjax )
                    break;
                case 'price-team':
                    var param = '?tab=price-team';
                    break;
                default:
                    break;
            }
            var newurl = window.location.protocol + "//" + window.location.host + window.location.pathname + param;
		    window.history.pushState({ path: newurl }, '', newurl);
        });

        $(document).on('click', '#worker-clickable, #action-clickable', function(){ 
            if($(this).attr('id') == 'worker-clickable')
                $(this).find('.dropdown-ul-menu').slideToggle(200); 
            else if($(this).attr('id') == 'action-clickable')
                $(this).find('.dropdown-ul-menu').slideToggle(200); 
        });
        $(document).on('click', '.user-items', function(){
            $_query.user = $(this).attr('data-user');
            $("#worker-btn").val($(this).text());
        });
        $(document).on('click', '.action-items', function(){
            $_query.useraction = $(this).attr('data-action');
            $("#action-btn").val($(this).text());
        });
        $(document).on('click', '.website-items', function(){
            $_query.website = $(this).attr('data-website');
            $("#website-btn").val($(this).text());
        });
        $(document).on('click', '#check-btn', function(){
            AjaxCall($url,$_query).done( recentActAjax )
        });


    //END 
    });

function setActiveTab($param){
	$('.header-menu-item').removeClass('active-item-menu');
	$('.act-content').hide();
	switch($param){
		case 'price-team':
			var $dataDiv = 'price-team';
		break;
		default:
			var $dataDiv = 'recent-activity';
            getUsersItems();
            AjaxCall($url,$_query).done( recentActAjax )
		break;
	}
    $('#'+ $dataDiv).show();
	$('#menu-'+ $dataDiv).addClass('active-item-menu');
}

function getUsersItems(){
    $("#populate-users").empty();
    var $data = {action : "getAllUsers"}
    AjaxCall($url, $data).done(function(data){
        for(var i in data){
            var user = data[i].username.substr(0,1).toUpperCase()+data[i].username.substr(1).toLowerCase();
            var app = '<li class="user-items" data-user='+data[i].username+'>'+user+'</li>';
            $("#populate-users").append(app);
        }
    });
}

function recentActAjax(data){
    $("#recent-activity-body").empty();
    console.log(data.length)
    if(data.length != 0){
        for(var i in data){
            var game_id = (data[i].normalised_name == null) ? '----' : data[i].normalised_name;
            var worker = data[i].worker.substr(0,1).toUpperCase()+ data[i].worker.substr(1).toLowerCase();
            var app  = '<tr class="tr-content">';
                app +=    '<td class="date">'+strtotime_javascript_time(data[i].time,"Asia/Manila")+'</td>';
                app +=    '<td class="name">'+worker+'</td>'
                app +=    '<td class="action">'+data[i].action+'</td>'
                app +=    '<td class="game_id">'+game_id+'</td>'
                app +=    '<td class="link">'+data[i].url+'</td>'
                app +=    '<td class="site">'+data[i].site+'</td>'
                app += '</tr>'
            $("#recent-activity-body").append(app);
        }
    }else{
        alertMsg("No Data Found")
    }
    
}
 
function strtotime_javascript_time(epoch,$tzString) {
	var dateY = new Date(epoch*1000).toLocaleString("en-US",{timeZone: $tzString});
	return (dateY != '') ? dateY : 'No Data';
}

</script>
<style>
.act-th-class {
    padding: 10px;
    font-weight: normal !important;
}
.act-cda-table-h-sticky {
    position: sticky;
    background-color: #0062cc;
    top: 88px;
}
.date{width:13%}
.link{width:60%; word-break: break-all;}
#recent-activity-body{ font-size: 14px; }
#recent-activity-table td{ padding: 5px 10px 5px 10px; }
.tr-content:nth-child(2n) { background-color: #ddd; }

</style>
<?php $this->end(); ?>

<?php $this->start('body')?>
<div class="container-fluid">
    <div class="row">
        <div class="col-lg-12 col-md-12">
            <div class="card-body rdl-card-main-wrap no-padding">
                <div class="card-div-overflow-style row-1-card-div-overflow-style row-1-card-div-overflow-style-1">
					<p class="card-bulletin header-card-bulitin">MENU :</p>
					<ul class="header-ul-menu">
						<li class="header-menu-item active-item-menu" id="menu-recent-activity" data-div="recent-activity">Recent Act.</li>
						<li class="header-menu-item" id="menu-price-team" data-div="price-team">Price Team</li>
					</ul>
				</div>
            </div>
        </div>
    </div>
</div>
<div id="recent-activity" class="act-content">
    <div class="container-fluid">
        <div class="row">
            <div class="col-lg-12 col-md-12 mtop-35px">
                <div class="card card-style">
                    <div class="card-body rdl-card-main-wrap no-padding">
                        <!-- HEADER STARTS row-4-card-div-overflow-style-->
                            <div class="card-div-overflow-style row-4-card-div-overflow-style-2" style="position:relative; padding-top:20px;">
                                <div class="row" style="color:#fff;margin: 0;">
                                    <div class="div-topheader-1 col-lg-9">
                                        <h5 style="display: inline-block; margin-right: 10px;">Recent Activities</h5>
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
                            <div class="col-xs-12 div-body-table" class="merchant-edition">
                                <div class="col-lg-12 no-padding" id="merchant-edition">

                                   <div class="col-lg-2 no-padding" style="padding-bottom:10px; display:inline-block;">
                                        <div id="worker-clickable">
                                            <div class="dropdown-container row-4-card-div-overflow-style-2">
                                                <div class="selected-item-container">
                                                    <span class="selected-item"><input id="worker-btn" class="website-btn" type="button" value="Worker"></span>
                                                    <span class="position-icon-1"><i class="fas fa-caret-down" ></i></span>
                                                </div>
                                                <ul id="populate-users" class="dropdown-ul-menu" style="height:350px; display:none;">
                                                    <li class='user-items' data-user="edmund">Edmund</li>
                                                </ul>
                                            </div>
                                        </div>
                                        
                                    </div>
                                    <div class="col-lg-2 no-padding" style="padding-bottom:10px; display:inline-block;">
                                        <div id="action-clickable">
                                            <div class="dropdown-container row-4-card-div-overflow-style-2">
                                                <div class="selected-item-container">
                                                    <span class="selected-item"><input id="action-btn" class="website-btn" type="button" value="Action"></span>
                                                    <span class="position-icon-1"><i class="fas fa-caret-down" ></i></span>
                                                </div>
                                                <ul id="populate-actions" class="dropdown-ul-menu" style="display:none;">
                                                    <li class='action-items' data-action="created">Create</li>
                                                    <li class='action-items' data-action="modified">Modified</li>
                                                    <li class='action-items' data-action="opens">Opens</li>
                                                    <li class='action-items' data-action="changed_price">Changed Price</li>
                                                    <li class='action-items' data-action="deleted">Deleted</li>
                                                </ul>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="col-lg-1 no-padding" style="padding-bottom:20px; display:inline-block;">
                                        <div class="row-4-card-div-overflow-style-2" style="border-radius:5px">
                                            <input id="check-btn" class="website-btn" type="button" value="Check">
                                        </div>
                                    </div>      
                                    
                                </div>
                            </div>
                            <div class="col-xs-12 div-body-table mt-2 mb-2" class="merchant-edition">
                                
                                <table id="recent-activity-table" class="col-12">
                                    <thead class="text-white">
                                        <tr>
                                            <th class="act-th-class act-cda-table-h-sticky">Date</td>
                                            <th class="act-th-class act-cda-table-h-sticky">User</td>
                                            <th class="act-th-class act-cda-table-h-sticky">Action</td>
                                            <th class="act-th-class act-cda-table-h-sticky">GameID</td>
                                            <th class="act-th-class act-cda-table-h-sticky">Link</td>
                                            <th class="act-th-class act-cda-table-h-sticky">Site</td>
                                        </tr>
                                    </thead>
                                    <tbody id="recent-activity-body">
                                        
                                    </tbody>
                                </table>

                            </div>

                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

<div id="price-team" class="act-content" style="display:none">
    <div class="container-fluid">
        <div class="row">
            <div class="col-lg-12 col-md-12 mtop-35px">
                <div class="card card-style">
                    <div class="card-body rdl-card-main-wrap no-padding">
                        <!-- HEADER STARTS row-4-card-div-overflow-style-->
                            <div class="card-div-overflow-style row-4-card-div-overflow-style-2" style="position:relative; padding-top:20px;">
                                <div class="row" style="color:#fff;margin: 0;">
                                    <div class="div-topheader-1 col-lg-12">
                                        <h5 style="display: inline-block; margin-right: 10px;">Price Team</h5>
                                        <p style="font-size:12px;font-weight: 500;">Check using by users</p>
                                    </div>                                    
                                </div>
                            </div >
                        <!-- CONTENT STARTS -->
                            <div class="col-xs-12 div-body-table mt-4 mb-2" class="merchant-edition">
                                
                                <table class="col-12">
                                    
                                </table>

                            </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

<?php $this->end()?>

