<?php $this->setSiteTitle($this->pageTitle); ?>
<?php $this->start('head'); ?>
<link rel="stylesheet" href="<?=PROOT?>vendors/css/links-page.css" media="screen" title="no title" charset="utf-8">
<script type="text/javascript" src="https://cdnjs.cloudflare.com/ajax/libs/underscore.js/1.12.0/underscore-min.js"></script>
<!-- data tables -->
<link type="text/css" rel="stylesheet" href="https://cdn.datatables.net/1.10.22/css/jquery.dataTables.min.css" >
<link type="text/css" rel="stylesheet" href="https://cdn.datatables.net/responsive/2.2.6/css/responsive.dataTables.min.css">
<script type="text/javascript" src="https://cdn.datatables.net/1.10.22/js/jquery.dataTables.min.js"></script>

<script type="text/javascript">
	//ESCAPE SPECIAL CHARACTERS
	var $dataOpt = {
		action: 'fd-display-merchant',
		website : 'aks'
	};
	var $dataGetFeed = {
		action: 'fd-get-data',
		website : null,
		id : null,
        store: null
	};
	var globalSite = "aks";
	var feedTable = $('#display-feed-table').DataTable();
	$(document).ready(function(){
        //populate merchant
		AjaxCall(url, $dataOpt).done(populateMerchant); 
        
        //FOR DROP DOWN SELECT ANIMATION
		$('.option-click, .option-click-1').click( function() {
            if($(this).attr('data-toggle') == 'Merchant')
			    $(this).find('.option-menu-click').slideToggle(200);
		});

        //search merchant in input text
		$(document).on('keyup','.input-search-merchant', function() {
            var typo = regExpEscape(this.value);
			if($(this).closest('div').attr('data-content') == 'Merchant'){
                $('.searchable-ul .li-store .name').each(function(){
                    if($(this).text().search(new RegExp(typo, "i")) < 0)
                        $(this).closest('li').fadeOut(500);
                    else 
                       $(this).closest('li').fadeIn(500);
                });
            }
        });

        //when selecting website
        $(document).on('click', '.website-items', function(){
			$('ul.merchant-menu').empty();
			let $site = $(this).data('website');
            $('.website-btn').val('Loading...')
			$dataOpt.website = $site;
			globalSite = $site;
			$target = 'fd-select-merchant';
			AjaxCall(url, $dataOpt).done(populateMerchant);
		});

        //search url in datatable
        $('#test-search').keypress(function(e){
			if(e.which == 13){
				$(this).blur();
			}
		});
        //search url in datatable
		$(document).on('focusout', '#test-search', function(){
			let $id = $('.select-text').attr('data-id');
			var $data3 = {
				action : 'feed-search',
				link: this.value,
				website : globalSite,
				id : $dataGetFeed.id
			}
			AjaxCall(url, $data3).done(function(data){
				console.log(data)
				$('.search-labells').val(data).trigger("keyup");
			});
        });

        $(document).on('click', '.li-store', function(){
            var $id = $(this).attr('data-merId');
            $('.header-title-page').text('Loading ...');
            $('#test-search').hide();
			$('#test-search').val("");
            $dataGetFeed.store = $(this).find('.name').attr('data-name');
            $dataGetFeed.website = $dataOpt.website;
			$dataGetFeed.id = $id;
            AjaxCall(url, $dataGetFeed).done(function(data){
            if(data != 'No merchant found'){
                var items = []; 
                var $columnCJS = [
                        { title : "URL", class: 'data-url'},
                        { title : "SKU", class: 'data-sku'},
                        { title : "PRICE", class: 'data-price'},
                        { title : "STOCK", class: 'data-stock'},
                    ];
                    if($id == 67){
                        var $col = 3;
                        var $columnFinal = $columnCJS;
                        for (var i in data){
                            items.push([
                                html_decode(data[i].url),
                                html_decode(data[i].sku),
                                data[i].price,
                                dispo(data[i].stock),
                            ]);
                        }
                    }else{
                        var $col = [1,3];
                        var $hideCol = [1];
                        var $columnFinal = $columnCJS;
                        for (var i in data){
                            items.push([
                                html_decode(data[i].url),
                                '',
                                data[i].price,
                                dispo(data[i].stock),
                            ]);
                        }
                    }
                            
                    feedTable = $('#display-feed-table').DataTable({
                        destroy: true,
                        responsive: true,
                        pageLength: 25,
                        lengthMenu: [[25, 50, 100, 500, 1000, 5000, 10000, -1],[25, 50, 100, 500, 1000, 5000, 10000, "All"]], // Sets up the amount of records to display
                        scrollX: 420,
                        data: items,
                        search: {
                            "addClass": 'search-bar'
                        },
                        language: {
                            "search": "_INPUT_",            // Removes the 'Search' field label
                        },
                        columns: $columnFinal,
                        columnDefs: [
                            { searchable: false, targets: $col },
                            { visible: false   , targets: $hideCol }
                        ]
                    });
                $('.dataTables_filter input[type="search"]').attr('placeholder','Search ...').addClass('search-labells');
                $('.dataTables_filter input[type="search"]').closest('label').addClass('data-labells')
            }
            }).always(function(data){
                if(data != 'No merchant found'){
                    $('.header-title-page').text($dataGetFeed.store+' '+$id+ ' Feed');
                    $('#display-feed-table_wrapper, #test-search').show();
                }else{
                    $('.header-title-page').text('No Merchant Found');
                    alertMsg("No Merchant Found");
                }
            });

        });

	//end
	});
	
	// function AjaxCall($url, $data, $target){
	// 	return $.ajax({
	// 		url: $url,
	// 		method:'POST',
	// 		data: $data,
	// 		beforeSend: function(){	
	// 			processBeforeSend($target)
	// 		},
	// 	})
	// }

	function processBeforeSend($target, param = false){
		switch ($target) {
			case 'fd-select-merchant':
				$('.select-text').text('Loading...');
				break;

			case 'fd-display-feed':
				$('.select-text').text('Loading...');
				$('.update-mer').text('');
				$('.loader-feed-display').show();
				$('#display-feed-table_wrapper').hide();
				break;
			default:
			break;
		}
	}
    function populateMerchant(data){
        for(var i in data){
            let $nameText = data[i].name.substr(0,1).toUpperCase()+data[i].name.substr(1).toLowerCase(); 
			let appendData = addMerchantOption(data[i].merchant_id, $nameText, data[i].merchant_id);
			$('ul.merchant-menu').append(appendData);
		}
        $('.website-btn').val($dataOpt.website.toUpperCase())
        $('.input-search-merchant').attr('placeholder',$dataOpt.website.toUpperCase()+' Merchants' )
    }
	function addMerchantOption($merchant, $name, $id){
		var appendData = 	'<li class="li-store" data-merId="'+$merchant+'">';
			appendData +=		'<span class="name" data-name="'+$name+'">'+$name+' '+$id+' </span>';
			appendData +=	'</li>';
		return appendData;
	}
	function dispo(dispo){
        return (dispo == 1) ? '<span class="text-success"><b>In Stock</b></span>' : '<span class="text-danger"><b>Unavailable</b></span>';
    }

</script>
<style type="text/css">
    .searchable-ul{
        max-height: 400px;
    }
	.dp-fdisplay{ width: 300px !important; }
	.name{
		font-weight: 500;
		margin-right: 5px;
	}
	.dataTables_scrollHead{
		background: linear-gradient(60deg, #004ea3, #0062cc) !important;
		color: #fff;
	}
	#display-feed-table_filter{ width: 100%; }
	.data-labells{ width:100% !important; }
	.search-labells{
		display: none;
		width:100%;
		margin-top: 10px;
		margin-bottom:10px;
	}
	table.dataTable tbody tr.even { background-color: #f7f7f7 !important; }
	table.dataTable tbody tr:hover{ background-color: #daedff !important; }
	.merchant{
		padding: 5px;
		color:#fff;
		background-color: #3f51b5;
	}
	.header-note{
		padding: 10px;
	}
	.update-mer{ margin:0; padding-bottom:5px;}
	#test-search{
		margin-bottom: 10px;
		display:none;
	}
	.data-url{  
        min-width:300px;
        word-break: break-all; 
    }
	.data-sku{ width:10%; }
	.data-price{ width: 6%; }
	.data-stock{ width: 8%; }
	.text-note{
		position: absolute;
	}
    .cus-icon-style{
        color :#212529;
        top: 8px;
    }
</style>
<?php $this->end(); ?>


<?php $this->start('body'); ?>
<div class="container-fluid">
    <div class="row">
        <div class="col-lg-12 col-md-12 mtop-35px">
            <div class="card card-style">
                <div class="card-body no-padding">
                    <!-- HEADER STARTS row-4-card-div-overflow-style-->
						<div class="card-div-overflow-style row-4-card-div-overflow-style-2" style="position:relative; padding-top:20px;">
							<div class="row" style="color:#fff;margin: 0;">
                                <div class="header-div col-lg-10">
									<h5 class="header-title-page" style="letter-spacing:1.5px;">Merchant Feed Check</h5>
									<p class="header-text-paragraph">Note: For better searching pls add a correct affiliate link on the respected merchant</p>
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
                        </div>
                        <!-- CONTENT STARTS -->
                        <div>
                            <div class="dropdown-box dbox-hide" style="padding-bottom: 5px;">
                                <div class="dropdown-merchant option-click div-0 col col-md-3 no-padding" data-toggle="Merchant">
									<div class="selected-merchant row-4-card-div-overflow-style-2" data-content="Merchant" style="padding:1px">
                                        <span class="selected-merchant"><input type="text" class="input-search-merchant form-control" data-search="search" placeholder="Merchant"></span>
										<span class="position-icon-1 cus-icon-style"><i class="fas fa-caret-down" aria-hidden="true"></i></span>
									</div>
									<ul class="merchant-menu option-menu-click searchable-ul scrollbar-custom">
                                        
                                        
									</ul>
								</div>
                            </div>
                        </div>
                        <div class="col-lg-12 no-padding array-display mb-4" style="margin-top: 10px;">
                            <input type="text" name="" id="test-search" class="form-control" style="width: 100%" placeholder="Search ..." >
                            <table id="display-feed-table" width="100%" style="font-size: 12px;">
                            
                                <?php 
                                    //preg_match_all('/\D+\[(.*)\]\s.*Array\D+(\d+\.\d+)\D+(\d+)\D+\[(sku|link)\]\D+?\D\D\D(.*)/',$_SESSION['feed'], $con); //para cjs
                                    //echo "<pre>", print_r($_SESSION['feed'],1), "</pre>"; //for testing porposes
                                    //unset($_SESSION['feed']); //for testing porposes
                                ?>
                            </table>
                                
                        </div>
                </div>
            </div>
        </div>
    </div>
</div>
<?php $this->end();?>