var currentDisplay = 0,
	currentID = '',
	total = '',
	toSearch = '',
	toClose = '';

$(document).ready(function(){
	displayStore();

	$(document).on('click', '.store-games-data-table-tbody-data', function(){
		var selection = window.getSelection();
		if(selection.type != "Range") displayStoreGamesByNormalizedName($(this).data('nname'), $('.dropdown-menu-btn').text());
	});

	$(document).on('keyup paste', '.store-page-search', function(){
		searchKeyUp($(this).val());
	});

	
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

	$(document).on('change', '.modal-val-txt', function(){
		storeUpdateProduct($(this).attr('data-prodId'), 'price', $(this).val(), $('.dropdown-menu-btn').text());
	});
			
	$(document).on('click', '.modal-val-btn', function(){
		storeUpdateProduct($(this).attr('data-prodId'), 'stock', $(this).val(), $('.dropdown-menu-btn').text());
		$stock = ($(this).val() == 'Out Of Stock')? $(this).val('In stock'): $(this).val('Out Of Stock'); 
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