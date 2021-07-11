<?php $this->setSiteTitle($this->pageTitle); ?>
<?php $this->start('head'); ?>
<link rel="stylesheet" href="<?=PROOT?>vendors/css/links-page.css" media="screen" title="no title" charset="utf-8">
<script type="text/javascript" src="https://cdnjs.cloudflare.com/ajax/libs/underscore.js/1.12.0/underscore-min.js"></script>
<!-- data tables -->
<link type="text/css" rel="stylesheet" href="https://cdn.datatables.net/1.10.22/css/jquery.dataTables.min.css" >
<link type="text/css" rel="stylesheet" href="https://cdn.datatables.net/responsive/2.2.6/css/responsive.dataTables.min.css">
<script type="text/javascript" src="https://cdn.datatables.net/1.10.22/js/jquery.dataTables.min.js"></script>

<script type="text/javascript">

var conMerchant = [];
var merchant = null;
var feedTable = $('#display-feed-table').DataTable();

$(function(){
	$.when([ getMerchant('aks') ]).then( () => {
		console.log("Ajax Done")
	});

	//search filder merchant
	$(document).on('click input', '.fd-merchant-selinp',function(){
		$('.dropdown-menu-div').hide();
		$('.fd-dmd-merchant').show().empty();
		var matcher = new RegExp( regExpEscape(this.value) , "i");
		var getOuput = conMerchant.filter(function (items) {
			return matcher.test(items.search)
		});
		for(var i in getOuput){
			$('.fd-dmd-merchant').append(getOuput[i].toAppend) 
		}
	});

	//when selecting website
	$(document).on('click', '.website-items', function(){
		$('#test-search').hide();
		let $website = $(this).attr('data-website');
		getMerchant($website)
	});

	$(document).on('click', '.fd-dmds-merchant', function(){
		var $value = $(this).attr('data-fd-merchant-ni')+' '+$(this).attr('data-merchant-id-ni');
		$('#test-search').hide();
		$('#test-search').val("");
		$('#display-feed-table_wrapper').hide();
		$('#display-feed-table').empty();
		$('.fd-merchant-selinp').val($value);
		$merchant = $(this).attr('data-merchant-id-ni');
		$website = $(this).parent().attr('data-website');
		$store = $('.fd-select-input').val();

		$.when([ fetchingFeed($website, $merchant, $store) ]).then( () => {
			console.log("Ajax Done Remove loading if done")
		});
	});

	//select website
	// $(document).on('click', '.fd-dd-select-site',function(){
	// 	$('.dropdown-menu-div').hide();
	// 	$('.dmd-select-site').show();
	// });

	//search url in datatable
	$('#test-search').keypress(function(e){
		if(e.which == 13){
			$(this).blur();
		}
	});
	//search url in datatable
	$(document).on('focusout', '#test-search', function(){
		let $id = $('.select-text').attr('data-id');
		const $data3 = {
			action : 'feed-search',
			link: this.value,
			website : $('.fd-dmd-merchant').attr('data-website'),
			id : $merchant
		}
		AjaxCall(url, $data3).done(function(data){
			console.log(data)
			$('.search-labells').val(data).trigger("keyup");
		});
	});
});

function fetchingFeed($website , $merchant, $store){
	const dataRequest = {
		action: 'fd-get-data',
		website : $website,
		id :$merchant,
	}
	AjaxCall(url, dataRequest).done(function(data){
		if(data != 'No merchant found'){
			var items = []; 
			var $columnCJS = [
				{ title : "URL", class: 'data-url'},
				{ title : "SKU", class: 'data-sku'},
				{ title : "PRICE", class: 'data-price'},
				{ title : "STOCK", class: 'data-stock'},
			];
			if($merchant == 67){
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
			$('.header-title-page').text($store + ' Feed');
			$('#display-feed-table_wrapper, #test-search').show();
			merchant = $merchant
		}else{
			$('.header-title-page').text('No Merchant Found');
			alertMsg("No Merchant Found", "bg-danger");
		}
	});
}

function getMerchant($website = 'aks'){
	conMerchant = []
	const dataRequest =  {
		action: 'fd-display-merchant',
		website : $website
	}
	AjaxCall(url, dataRequest).done(function(data) {
		for(var i in data){
			var name = data[i].name.substr(0,1).toUpperCase()+data[i].name.substr(1).toLowerCase();
			conMerchant.push({
				'id' : data[i].merchant_id,
				'name' : name,
				'search': name +' '+ data[i].merchant_id,
				'toAppend': '<div class="dropdown-menu-div-sub fd-dmds-merchant" data-fd-merchant-ni="'+ name +'" data-merchant-id-ni='+data[i].merchant_id+'><span class="dmds-data-name">'+ name +'</span>  <span class="dmds-data-id"> '+data[i].merchant_id+' </span></div>'
			});
		}
	}).always(function() {
		feedTable.destroy();
		$('#display-feed-table').empty();
		$('.fd-si-span').text($website.toUpperCase() +' '+ 'Merchants');
		$('.fd-dmd-merchant').attr( 'data-website', $website.toLowerCase() );
		$('#website-btn').val($website.toUpperCase());
	});
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
	
	.fd-select-input:focus ~ .fd-si-span {
		right:  0 !important;
	}
	.dropdown-btn {
		left: 0;
		border: transparent;
		/*border-left: solid 1px transparent;*/
		width: 100%;
		border-radius: 5px;
		cursor: pointer;
		background-color: #007bff;
		color: #fff;
		font-size: 18px;
	}
	button:focus {
		outline: none !important;
	}
	.dropdown-btn:hover{
		background-color: #0069d9;
	}
</style>
<?php $this->end(); ?>


<?php $this->start('body'); ?>
<div class="container-fluid">
	<div class="row">
		<div class="col-lg-12 col-md-12 mtop-35px">
			<div class="card card-style card-normalmode">
				<div class="card-body no-padding" style=""> 
					<div class="card-div-overflow-style row-4-card-div-overflow-style-2" style="position:relative; padding-top:20px;">
						<div class="row" style="color:#fff;margin: 0;">
							<div class="header-div col-lg-10">
								<h5 class="header-title-page" style="letter-spacing:1.5px;">Merchant Feed Check</h5>
								<p class="header-text-paragraph">Note: For better searching pls add a correct affiliate link on the respected merchant</p>
							</div>
							<div class="col-lg-2" style="padding-bottom:20px;">
                                <div class="col-lg-12">
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
						</div>
					</div>
					<div class="me-content-div" style="">
						<div class="row" style="padding: 10px 0;">
							<div class="col-xxl-6 col-xl-3 col-sm-6">
								<div class="dropdown">
									<input type="text" name="" class="input-text-class dropdown-inputbox fd-select-input fd-merchant-selinp" autocomplete='off' style="left: 0;border-left: solid 2px #ccc;border-right: none;padding: 0 5px; border-radius: 5px 0 0 5px;" required>
									<i class="input-text-i fal fa-angle-down"></i>
									<span class="input-text-span fd-si-span" style="left: 5px">Select Merchant</span>
									<span class="input-text-border"></span>

									<div class="dropdown-menu-div fd-dmd-merchant scrollbar-custom" data-dropdown="Merchant">
										<!-- data from database -->
									</div>
								</div>
							</div>
						</div>
					</div>
					<div class="col-lg-12 no-padding array-display mb-4" style="margin-top: 5px;">
                        <input type="text" name="" id="test-search" class="form-control" style="width: 100%" placeholder="Search ..." >
                        <table id="display-feed-table" width="100%" style="font-size: 12px;">
                            <!-- data from ajax -->
                        </table>     
                    </div>

				</div>
			</div>
		</div>
	</div>
</div>
<?php $this->end();?>