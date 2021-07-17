
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