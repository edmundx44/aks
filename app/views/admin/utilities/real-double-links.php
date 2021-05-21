

<?php $this->setSiteTitle($this->pageTitle); ?>

<?php $this->start('head'); ?>
	<link rel="stylesheet" href="<?=PROOT?>vendors/css/utilities-page.css" media="screen" title="no title" charset="utf-8">
	<link rel="stylesheet" href="<?=PROOT?>vendors/css/store-page.css" media="screen" title="no title" charset="utf-8">
    <script type="text/javascript" src="https://cdnjs.cloudflare.com/ajax/libs/underscore.js/1.12.0/underscore-min.js"></script>
	<!-- data tables -->
	<link type="text/css" rel="stylesheet" href="https://cdn.datatables.net/1.10.22/css/jquery.dataTables.min.css" >
    <link type="text/css" rel="stylesheet" href="https://cdn.datatables.net/responsive/2.2.6/css/responsive.dataTables.min.css">
	<script type="text/javascript" src="https://cdn.datatables.net/1.10.22/js/jquery.dataTables.min.js"></script>
	<!-- another method for responsive reorder datatables -->
    <!-- <script type="text/javascript" src="https://cdn.datatables.net/rowreorder/1.2.7/js/dataTables.rowReorder.min.js"></script>
    <script type="text/javascript" src="https://cdn.datatables.net/responsive/2.2.6/js/dataTables.responsive.min.js"></script> -->
    <!-- data tables -->

	<script type="text/javascript">
		var $url = url+'utilities/realDouble';
		$globalSite=null;
		$(function(){
			$('.dropdown-div').html(OptionSite(inputsSite,'opt-site-rdb','slc-options','custom-bkgd')); //OptionSite na a sa custom.js
			// if (!removeExistingItem('sessionStorage','OptionSite',uri)){
			// 	console.log('Item has been removed');
			// }
			if(sessionStorageCheck()){
				$('.change-site').text('LOADING...');
				var object = JSON.parse(getStorage('sessionStorage','OptionSite'));
				if(object != null){
					site = returnSite(object.site);
					if(site != 'invalid'){
						_ajaxCall($url,"POST","AjaxRealDblLinks",site).done(function(data){
							done_ajaxCall_RDB(site,data)
						});
					}else{ if(removedKeyNormal('sessionStorage','OptionSite')) console.log("Item has been removed") } //remove key if invalid site
				}else{
					//if null default value is aks
					console.log(inputsSite[0].site)
					_ajaxCall($url,"POST","AjaxRealDblLinks",inputsSite[0].site).done(function(data){
						done_ajaxCall_RDB(inputsSite[0].site,data)
					});
				}
			}
			// na na ni sa index.php sa dashboards
			//FOR DROP DOWN SELECT ANIMATION
			$('.dropdown-div').click(function () {
				$(this).find('.dropdown-menu').slideToggle(200);
			});

			$('.dropdown-div').focusout(function () {
				$(this).find('.dropdown-menu').slideUp(200);
			});

			// $('#table-real-double-link').on( 'keyup', function () {
			//     var regExSearch = '^\\s' + myValue +'\\s*$';
			// 	table.column(2).search(regExSearch, true, false).draw();
			// 	console.log(regExSearch)
			// } );

			$(document).on('click', '.opt-site-rdb', function() {
				//every click it reset the value if modify in console
				$('.dropdown-div').html(OptionSite(inputsSite,'opt-site-rdb','slc-options','custom-bkgd')); //OptionSite na a sa custom.js
				$('.change-site').text('LOADING...');
			    var indexInput = $(this).parent().prevObject.index(); //get the index of li
			    if($(this).parent()[0].childNodes.length == 3 ){
			    	site = (indexInput == 0 ) ? inputsSite[0].site : (indexInput == 1 ) ? inputsSite[1].site : (indexInput == 2 ) ? inputsSite[2].site : '';
					var $data = { 'site': site, 'path': $url }
					if(sessionStorageCheck()){ setStorage('sessionStorage','OptionSite',JSON.stringify($data)) }
					_ajaxCall($url,"POST","AjaxRealDblLinks",site).done(function(data){
						done_ajaxCall_RDB(site,data)
					});
			    }else{ window.location.reload(); }
			});

			$(document).on('click', '#open-store-modal', function(){
				if($globalSite != null)
					displayStoreGamesByNormalizedName($(this).data('nname'),$globalSite.toUpperCase());
			});

		});

		function done_ajaxCall_RDB(site,data){
			var items = [];
			$globalSite = site;
			for (var i in data){    
				var dispo = dispoDisplay(data[i].dispo); 
				var btnAction = actionRealDblBtn(data[i].id); 
				var buy_url = gotoGameIdPage(site,data[i].normalised_name,data[i].buy_url,$url);
			    var toPush = [ buy_url, data[i].price, dispo, data[i].normalised_name, btnAction ]
			    items.push(toPush);
			}
			$('#table-real-double-link').show();
				if(items != null){
					$('#table-real-double-link').DataTable({
						destroy: true,
				        responsive: true,
				        pageLength: 25,
				        lengthMenu: [[25, 50, 100, -1],[25, 50, 100, "All"]], // Sets up the amount of records to display
				        scrollX: 420,
				        data: items,
				        search: {
			  	        	"addClass": 'search-bar'
			  	    	},
				        language: {
			        		"search": "_INPUT_",            // Removes the 'Search' field label
			    		},
				        columns: [
				            { title : "LINK", class: 'title-rdb-0 all', width:'70%' },
				            { title : "PRICE", class: 'text-center all'},
				            { title : "STOCK", class: 'text-center', width:'80px'},
				            { title : "GAME_ID", class: 'text-center'},
				            { title : "ACTION", class: 'd-true all'}
				        ]
				    }) //.columns.adjust().responsive.recalc(); //commented caused i commented the reorder
				}
			$('.change-site').text(site.toUpperCase());
			$('.dataTables_filter input[type="search"]').
  				attr('placeholder','Search ...').
  				css({'width':'350px','display':'inline-block'});

		}

		function dispoDisplay(dispo){
	        if(dispo == 1){
	            return dispo = '<span class="text-success"><b>In Stock</b></span>';
	        }else{
	            return dispo = '<span class="text-danger"><b>Unavailable</b></span>';
	        }
    	}

	    function actionRealDblBtn($product_id){
	    	// return "<input type='button' value='ACTION' data-rdl-id="+$product_id+" id='btn-delete-real-dbl-link'>";
	    	return "<input type='checkbox' class='checkitem' id="+$product_id+" style='cursor:pointer;'>";
	    }

	    //href buy_url for REAL DOUBLE LINKS
	    function gotoGameIdPage(websiteToggle,normalised_name,url,path){
	    	//var newPath = path.replace(/akss\/utilities\/realDouble/,'');
	    	var newUrl = html_decode(url);
			return "<div id='open-store-modal' class='href-c' data-site="+$globalSite+" data-nname="+normalised_name+">"+newUrl+"</div>";
	        // if(websiteToggle === 'aks'){
	        //     //var  newGoto = newPath+'index.php?game_id='+normalised_name;
	        //     //return "<a class='href-c' href='"+ newGoto +"' target='_blank'>"+newUrl+"</a>"
	        // }else{
	        //     var newGoto = newPath+'index.php?game_id='+normalised_name+'&website='+websiteToggle;
	        //     return "<a class='href-c' href='"+ newGoto +"' target='_blank'>"+newUrl+"</a>"
	        // }
	    }
	</script>
<?php $this->end(); ?>



<?php $this->start('body')?>
	<div class="container-fluid">
		<div class="row">
			<div class="col-lg-12 col-md-12 mtop-35px">
				<div class="card card-style">
					<div class="card-body rdl-card-main-wrap no-padding">
						<!-- HEADER STARTS -->
						<div class="card-div-overflow-style row-4-card-div-overflow-style row-4-card-div-overflow-style-2">
						
							<div class="" style="padding-top: 20px; padding-left: 10px; color: white;">
								<h5>Real double link detection</h5>
								<p style="font-size:12px;font-weight: 500;">Links with the same merchant, game id, buy url, edition and region</p>
							</div>
						</div>
						<!-- CONTENT STARTS -->
						<div>
							<div class="dropdown-box dbox-hide" style="padding-bottom: 5px;">
 								<div class="dropdown-div" style="width: 150px;">
									 <!-- <div class="select custom-bkgd">
						                <span class="selected-data change-site">Website</span>
						                <span class="float-right"><i class="fas fa-caret-down"></i></span>
						            </div> -->
									<!-- <ul class="dropdown-menu cos-dropdown-menu slc-options">
										<li class="opt-site-rdb" data-website="aks">AKS</li>
										<li class="opt-site-rdb" data-website="cdd">CDD</li>
										<li class="opt-site-rdb" data-website="brexitgbp">BREXITGBP</li>
				                    </ul> -->
								</div>
								<div class="float-right">
									<input style="color:#fff;" type="button" name="" class="m-d col-xs-3 btn custom-bkgd-1" id="btn-getchksumreports" value="Delete Selected">
								</div>
							</div>
								<div class="col-xs-12 div-body-table" id="div-DBL-body">
									<table id="table-real-double-link" class="display" width="100%" style="font-size: 12px;">
									
									</table>
								</div>
						</div>
					</div>
				</div>
			</div>
		</div>
	</div>
<?php $this->end()?> 
