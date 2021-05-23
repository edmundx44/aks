<?php $this->setSiteTitle($this->pageTitle); ?>
<?php $this->start('head'); ?>
<link rel="stylesheet" href="<?=PROOT?>vendors/css/utilities-page.css" media="screen" title="no title" charset="utf-8">
<script type="text/javascript" src="https://cdnjs.cloudflare.com/ajax/libs/underscore.js/1.12.0/underscore-min.js"></script>
<link type="text/css" rel="stylesheet" href="https://cdn.datatables.net/1.10.22/css/jquery.dataTables.min.css" >
<link type="text/css" rel="stylesheet" href="https://cdn.datatables.net/responsive/2.2.6/css/responsive.dataTables.min.css">
<script type="text/javascript" src="https://cdn.datatables.net/1.10.22/js/jquery.dataTables.min.js"></script>

<script type="text/javascript">
    var $url = url+'utilities/metacriticsDouble';
    var $dataReq = { action: 'AjaxMetacriticsDblLinks', criticStore: 'Default' };

    $(function (){
        AjaxCall($url,$dataReq).done( ajaxSuccess );

        $(document).on('click', '.dropdown-merchant-me', function(){ $(this).find('.merchant-menu-me').slideToggle(200); })
        $(document).on('click','.li-store', function(){
            var metaMerchant =$(this).data('vali');
            $dataReq.criticStore = metaMerchant;
            AjaxCall($url,$dataReq).done( ajaxSuccess );
        });
    });
    function ajaxSuccess(data){
        if(data == "Invalid Information"){
            alertMsg('Invalid Critic Store')
        }else{
            var ajaxMetacriticResponse = [];
            $('#table-metacritics-double-link').show();
            for (var i in data){    
                var actionBtn = actionMetaModalDisplay( data[i].normalised_name,data[i].game_id);  
                var toPush = [
                        gotoMetaUrl(data[i].url),
                        data[i].game_id,
                        data[i].game_idname,
                        data[i].normalised_name,
                        data[i].userid,
                        data[i].game_type,
                        data[i].country,
                        data[i].date_added,
                        actionBtn
                    ]
                ajaxMetacriticResponse.push(toPush);
            }
            if(ajaxMetacriticResponse != null){
                $('#table-metacritics-double-link').DataTable( {
                    destroy: true,
				    responsive: true,
				    pageLength: 25,
				    lengthMenu: [[25, 50, 100, -1],[25, 50, 100, "All"]], // Sets up the amount of records to display
				    scrollX: 420,
                    data: ajaxMetacriticResponse,
                    columns: [
                        { title : "URL" },
                        { title : "GAME_ID" },
                        { title : "MERCHANT" },
                        { title : "NORMALISED NAME" },
                        { title : "USER ID" },
                        { title : "GAME TYPE" },
                        { title : "COUNTRY" },
                        { title : "DATE ADDED" },
                        { title : "ACTION" }
                    ]
                });
            }
        }
    }

    function gotoMetaUrl(url){
    	return "<a href='"+ url +"' target='_blank'>"+url+"</a>"
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
						<div class="card-div-overflow-style row-4-card-div-overflow-style-2" style="position:relative; padding-top:20px;">
							<div class="row" style="color:#fff;margin: 0;">
                                <div class="header-div col-lg-9">
									<h5 class="header-title-page">Metacritics double link detection</h5>
									<p class="header-text-paragraph">Double Link Detection same Normalised Name, Merchant Id/Game ID, Rating Type, Game Type and Country</p>
								</div>
							</div>
                        </div>
                        <!-- CONTENT STARTS -->
                        <div>
                            <div class="col-lg-12 div-body-table no-padding" id="metacritics-double">
                                <div class="dropdown-merchant-me option-click-1 col col-md-3 no-padding mb-4" data-toggle="meta-store">
									<div class="selected-merchant-me row-4-card-div-overflow-style-2" data-content="meta-store" style="padding:10px;">
                                        <span class="selected-merchant">Metacritics Stores</span>
										<span class="position-icon-1"><i class="fas fa-caret-down" aria-hidden="true"></i></span>
									</div>
									<ul class="merchant-menu-me option-menu-click-1 searchable-ul">
                                        <li class='li-store' data-vali="Default">Default</li>
                                        <li class='li-store' data-vali="24">24 = 24</li>
                                        <li class='li-store' data-vali="26">26 = 26</li>
                                        <li class='li-store' data-vali="25">Amazon Metacritics = 25</li>
                                        <li class='li-store' data-vali="17">Everyeye = 17</li>
                                        <li class='li-store' data-vali="1">Gamekult = 1</li>
                                        <li class='li-store' data-vali="9">Gamespot = 9</li>
                                        <li class='li-store' data-vali="4">Jeuxvideo = 4</li>
                                        <li class='li-store' data-vali="21">Meristation = 21</li>
                                        <li class='li-store' data-vali="8">Metacritics = 8</li>
                                        <li class='li-store' data-vali="15">PC Games = 15</li>
                                        <li class='li-store' data-vali="27">Steam Metacritic = 27</li>
									</ul>
								</div>
							</div>
                            <div class="col-lg-12 div-metacritic-body div-body-table" style="font-size: 14px;">
                                <table id="table-metacritics-double-link" class="display" width="100%">
                                        
                                </table>
                            </div>	
                        </div>
                </div>
            </div>
        </div>
    </div>
</div>
<?php $this->end()?> 