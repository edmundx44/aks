var currentDisplay = 0,
	currentID = '',
	total = '',
	toSearch = '',
	toClose = '';

var inputs = {
    text: "text",
    number: "number",
    button: "button"
}
$(function (){	
	displayStore();
	//console.log(url);
	$(document).on('click', '.store-games-data-table-tbody-data', function(){
		var selection = window.getSelection();
		if(selection.type != "Range") {
			$(".productNormalizedName").attr("data-product-website", $(".dropdown-menu-btn").html())
			displayStoreGamesByNormalizedName($(this).data('nname'),$('.dropdown-menu-btn').text());
		}
	});

	$(document).on('keyup paste', '.store-page-search', _.debounce(function(){
		// console.log($(this).val());
		searchKeyUp($(this).val());
	}, 350));

	
	$(document).on('click', '.add-edit-from-display', function(evt){
		// alert($(this).data('toeditid'));
		$('.add-edit-store-game-modal').modal('show');
	});

	$(document).on('click', '.breadcrumbs-ul', function(evt){
		if($(evt.target).is('.breadcrumbs-ul, .dropdown-items-store-page-search, .sticky-dropdown')) {
			if (scroll >= 220) $('.sticky-dropdown-menu-div').toggle();
		}
	});

	$(document).on('click', '.action-btn', function(){
		$('.show-menu').hide();
		$('.nname-modal-tbody-div').removeClass('hover-active-div');
				
		if ($(this).attr('id') == toClose) {
			$('#'+$(this).attr('id')).hide();
			$('.'+$(this).attr('id')).removeClass('hover-active-div');
			toClose = '';
		}else {
			$('#'+$(this).attr('id')).show();
			$('.'+$(this).attr('id')).addClass('hover-active-div');
			toClose = $(this).attr('id');
		}
	});

	$(document).on('click', '.dropdown-items-store-page-search', function(){
		$('.dropdown-menu-btn, .site-bcrumbs-span').text($(this).text());
		$('.breadcrumbs-ul').removeClass('AKS-sticky-BGC CDD-sticky-BGC BREX-sticky-BGC');
		if (scroll >= 220) $('.breadcrumbs-ul').addClass($('.dropdown-menu-btn').text()+'-sticky-BGC');
				
		switch($(this).text()) {
			case 'AKS':
				$('.store-card-div-page-title, .store-games-data-table-thead-data').removeClass('background-cdd background-BREX')
				$('.modal-child').removeClass('background-cdd-modal-title background-BREX-modal-title');
				$('.dropdown-menu-btn, .modal-close-btn').removeClass('background-cdd-btn background-BREX-btn');
				$('.store-page-search, .store-search-btn').removeClass('background-cdd-border background-BREX-border');
			break;
			case 'CDD':
				$('.store-card-div-page-title, .store-games-data-table-thead-data').removeClass('background-BREX');
				$('.store-card-div-page-title, .store-games-data-table-thead-data').addClass('background-cdd')

				$('.modal-child').removeClass('background-BREX-modal-title');
				$('.modal-child').addClass('background-cdd-modal-title');

				$('.dropdown-menu-btn, .modal-close-btn').removeClass('background-BREX-btn');
				$('.dropdown-menu-btn, .modal-close-btn').addClass('background-cdd-btn');

				$('.store-page-search, .store-search-btn').removeClass('background-BREX-border');
				$('.store-page-search, .store-search-btn').addClass('background-cdd-border');		
			break;
			case 'BREX':
				$('.store-card-div-page-title, .store-games-data-table-thead-data').removeClass('background-cdd');
				$('.store-card-div-page-title, .store-games-data-table-thead-data').addClass('background-BREX')

				$('.modal-child').removeClass('background-cdd-modal-title');
				$('.modal-child').addClass('background-BREX-modal-title');

				$('.dropdown-menu-btn, .modal-close-btn').removeClass('background-cdd-btn');
				$('.dropdown-menu-btn, .modal-close-btn').addClass('background-BREX-btn');

				$('.store-page-search, .store-search-btn').removeClass('background-cdd-border');
				$('.store-page-search, .store-search-btn').addClass('background-BREX-border');
			break;
		}

		searchKeyUp($('.store-page-search').val());
		if($('.store-page-search').val() != '' && scroll >= 220) $('.sticky-dropdown-menu-div').toggle();
	});

	//PRICE CHANGE UPDATE
	$(document).on('change', '.modal-val-txt', function(){
		var dataReturn = storeUpdateProduct($(this).attr('data-prodId'), 'price', $(this).val(), $('.dropdown-menu-btn').text());
		var $this = $(this);
		//FOR Mozilla because type number not working
		if(dataReturn == true){
			alertMsg("Check your input price...", "bg-danger")	
		}else{
			if($this.attr("type") == "number" && dataReturn.dataTo != '')
				AjaxCall(url, dataReturn).done(function(data) {
					if(data) alertMsg("SUCCESS")
				});
			else
				alertMsg("Check your input price...", "bg-success")	
		}
	});
	// STOCK CHANGE UPDATE
	$(document).on('click', '.modal-val-btn', function(){
		var dataReturn = storeUpdateProduct($(this).attr('data-prodId'), 'stock', $(this).val(), $('.dropdown-menu-btn').text());
		var $this = $(this);
		if($this.attr('type') == 'button'){
			AjaxCall(url, dataReturn).done(function(data) { console.log(data); alertMsg("SUCCESS", "bg-success")});
			$stock = ($(this).val() == 'Out Of Stock')? $(this).val('In stock'): $(this).val('Out Of Stock');
		}else
			alertMsg("Theres something wrong please try again", "bg-danger");
	});

	$(document).on('click', '.dall-function', function(){

		var getAllSum = parseInt(total) - parseInt(currentDisplay);
		displayStoreGames(currentID, currentDisplay, getAllSum, toSearch, $('.dropdown-menu-btn').text());
	});

	$(document).on('click', '.lmore-fucntion', function(){
		displayStoreGames(currentID, currentDisplay, 0, toSearch, $('.dropdown-menu-btn').text());
	});

	$(document).on('click', '.store-list-card', function(){
		currentDisplay = 0;
		currentID = '';
		total = '';
		toSearch = '';

		$('.breadcrumbs-ul').empty();
		$('.store-data-div').hide();
		$('.store-page-search').val('');
		$('.store-games-data-div').show();
		$('.store-games-data-table-tbody').empty();

		var getGames = displayStoreGames($(this).attr('id'), currentDisplay, 0, toSearch, $('.dropdown-menu-btn').text());
		breadCrumbs($(this).data('nname'));
	});


	$(document).on('click', '.store-bcrumbs, .site-bcrumbs', function(){
		$('.store-games-data-div').hide();	
		$('.store-data-div').show();
	});

	$(document).on('click', '.games-bcrumbs', function(){
		$('.store-data-div').hide();
		$('.store-games-data-div').show();	
	});

	$(document).on('click', function(event){    
		if(!$(event.target).is('.show-menu, .action-btn, .btn-icon-acb, .modal-setting-ul, .modal-setting-ul-li, .msulspan')) {
			$('.show-menu').hide();
			$('.nname-modal-tbody-div').removeClass('hover-active-div');
		}
	});		
}); // end document ready ---------------------------- //

function searchKeyUp($searchVal) {
	currentDisplay = 0;
	currentID = '';
	total = '';
	toSearch = '';
	if($searchVal != '' && $searchVal.length >= 3){
		$('.store-data-div').hide();
		$('.store-games-data-div').show();
		$('.store-games-data-table-tbody').empty();
		$('.breadcrumbs-ul').empty();
		toSearch = $searchVal;
		breadCrumbs('Search');

		displayStoreGames('', 0, 0, $searchVal, $('.dropdown-menu-btn').text());

	}else{
		$('.store-games-data-table-tbody').empty();
		$('.store-data-div').show();
		$('.store-games-data-div, .store-games-data-table-tfoot').hide();
		$('.games-bcrumbs').remove();
		currentDisplay = 0;
		currentID = '';
		total = '';
		toSearch = '';
	}
}

function displayStoreGames($merchantID, $offset, $limit, $toSearch, $site){
	var dataRequest =  {
		action: 'displayStoreGames',
		merchantID: $merchantID,
		offset: $offset,
		limit: $limit,
		toSearch: $toSearch,
		site: $site
	}

	var getMode = (localStorage.getItem("body-mode") == 'darkmode')? 'darkmode':'normal';
	AjaxCall(url, dataRequest).done(function(data) {
		var showHide = (data[0].total >= 499 || (data[0].total != '' && data[0].total >= 499))? $('.store-games-data-table-tfoot').show() : $('.store-games-data-table-tfoot').hide();
		for(var i in data){
			for(var j in data[0].data){
				var getStatus = (data[0].data[j].dispo == 1)? 'In Stock' : 'Out Of Stock';
				var append = '<tr class="store-games-data-table-tbody-data store-games-data-table-tbody-data-'+getMode+'" data-nname='+data[0].data[j].normalised_name+'>';
					append += '<td class="child-1">'+html_decode(data[0].data[j].buy_url)+'</td>';
					append += '<td class="child-2">'+data[0].data[j].price+'</td>';
					append += '<td class="child-3">'+getStatus+'</td>';
					append += '</tr>';

					$('.store-games-data-table-tbody').append(append);
			}
		}

		currentDisplay = parseInt(currentDisplay) + parseInt(data[0].currentDisplay);
		currentID = $merchantID;
		total = data[0].total;
	}).always(function() { 
		var hideIfMax = (currentDisplay == total)? $('.store-games-data-table-tfoot').hide() : '';
	});
}

function displayStore(){
	var dataRequest =  {
		action: 'displayStore'
	}

	AjaxCall(url, dataRequest).done(function(data) {
		for(var i in data){
			var append =  '<div class="col-md-12 col-lg-6 col-xl-3  store-list-div">';
				append += '<div class="card store-list-card" id="'+data[i].vols_id+'" data-nname="'+data[i].vols_nom+'"">';
				append += '<img class="card-img-top store-list-card-img-style" src="<?=PROOT?>vendors/image/store/.jpg" onerror="noImage(this);">';
				append += '<div class="card-body store-list-card-body">';
				append += '<p class="card-title store-list-store-name">'+data[i].vols_nom+' - '+data[i].vols_id+'</p>';
				append += '</div>';
				append += '</div>';
				append += '</div>';

				$(".store-data-div").append(append);
		}
	});
}

function noImage(image) {
	image.onerror = "";
	image.src = url+"vendors/image/no-image.jpg";
	return true;
}

function breadCrumbs($name){
	var append =  '<li class="site-bcrumbs"><span class="site-bcrumbs-span">'+$('.dropdown-menu-btn').text()+'</span></li>';	
		append += '<li class="store-bcrumbs">&nbsp;<i class="fas fa-arrow-right breadcrumbs-arrow"></i> Store</li>';	
		append += '<li class="games-bcrumbs"><i class="fas fa-arrow-right breadcrumbs-arrow"></i> '+ $name +'</li>';
		append += '<li class="">'
		append += '<button type="button" class="btn dropdown-toggle sticky-dropdown" data-toggle="dropdown"></button>'
		append += '<div class="dropdown-menu col-12 dropdown-menu-div sticky-dropdown-menu-div">'
		append += '<a class="dropdown-item dropdown-items-store-page-search" >AKS</a>'
		append += '<a class="dropdown-item dropdown-items-store-page-search" >CDD</a>'
		append += '<a class="dropdown-item dropdown-items-store-page-search" >BREX</a>'
		append += '</div>'
		append += '</li>'

		$(".breadcrumbs-ul").append(append);
}


