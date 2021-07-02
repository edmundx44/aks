var toggleVal = 0,
	sidebarDisplay = (localStorage.getItem("sidebar-active") == "sidebar-yes") ? sidebarDiv() : '',
	clickState = 0,
	docHeight = $(document).height(),
	docWidth = $(document).width(),
	$div = $('#float-anywhere'),
	divWidth = $div.width(),
	divHeight = $div.height(),
	heightMax = 800 - divHeight,
	widthMax = docWidth - divWidth,
	scroll = '',
	pageSwitch = 0;

var d = new Date();
var month = d.getMonth() + 1;
var day = d.getDate();

var crProblemArr = [];
var saveRegion = [];
var saveEdition = [];
var getVisibleArr = [];
var getAllowedRegionsArr = [];
var toCreateDataArr = [];

$div.css({
	left: Math.floor(Math.random() * widthMax),
	top: Math.floor(Math.random() * heightMax)
});


var queryString = window.location.search;
var uri = window.location.pathname;
//ESCAPE SPECIAL CHARACTERS
const entityMap = {
	'&': '&amp;',
	'<': '&lt;',
	'>': '&gt;',
	'"': '&quot;',
	"'": '&#39;',
	'/': '&#x2F;',
	'`': '&#x60;',
	'=': '&#x3D;',
	'¤': '&#164;'
};
const inputsSite = {
	0: { site: "aks" },
	1: { site: "cdd" },
	2: { site: "brexitgbp" },
}
const merchantsHolder = getMerchantsData();

$(document).ready(function () {
	removeEmptyTitle();
	displayIcon();
	displayMode(localStorage.getItem("body-mode"));
	getAllowedRegion();
	getVisible();

	$('.modal-dialog').draggable({
		handle: ".modal-content",
		cancel: 'span, input, .nfof-feedback, .pc-asb-modal*, .modal-content-body*, .spm-content-body*'
	});

	// var pathname = window.location.pathname;     
	// var origin   = window.location.origin;
	// var url      = window.location.href; 
	// localStorage.clear();

	$(document).on('click', '.dropdown-website', function () { $(this).find('.website-menu').slideToggle(200); });

	$(document).keydown(function (event) {


		if (event.which === 27) {
			// $('.modal').modal('hide');
		} else if ((event.which === 65 && event.shiftKey)) {
			$('.modal').modal('hide');
			$('.add-edit-store-game-modal').modal('show');
		} else if ((event.which === 68 && event.shiftKey)) {
			$('.switch-checkbox').trigger('click');
		} else if ((event.which === 81 && event.shiftKey)) {
			window.location.href = "/aks/dashboard/activities";
		} else if ((event.which === 82 && event.shiftKey)) {
			crProblemArr = [];
			$('.modal').modal('hide');
			$('#createReportModal').modal('show');
		} else if ((event.which === 83 && event.shiftKey)) {
			$('.modal').modal('hide');
			$('.header-search-btn').trigger('click');
		}

	});

	$(window).scroll(function () {
		scroll = $(window).scrollTop();
		scrollThis();
	});

	$(window).resize(function () {
		if ($(window).width() > 768) {
			$('.sidebar').removeClass('sidebar-reponsive');
			$('.bg-div').hide();
			pageSwitch = 0;
		}
	});

	$('[data-toggle="tooltip"]').tooltip();

	$("#float-anywhere").draggable({
		containment: "#wrapper",
		scroll: false
		// cancel:
	});

	$(document).on('click', '.li-darknormal-switch, .span-switch-name', function (e) {
		if (e.target == e.currentTarget) {
			$('.switch-checkbox').trigger('click')
		}
	});

	$(document).on('click', '.switch-checkbox', function () {
		if ($(this).is(":checked")) {
			if (scroll >= 220) $('.header-content-stickey').css({ 'background': 'rgba(39, 41, 61, 1)' });
			displayMode('darkmode');
		} else {
			if (scroll >= 220) $('.header-content-stickey').css({ 'background': 'rgba(255, 255, 255, 1)' });
			displayMode('normal');
		}
	});

	$(document).on('click', '.logout-function-on-li', function () {
		window.location.href = $(this).data('urlni');
	});



	$(document).on('click', '.float-settings-menu', function () {
		$('.modal').modal('hide');
		switch ($(this).attr('id')) {
			case 'btn-create-report':
				crProblemArr = [];
				$('#createReportModal').modal('show');
				break;
			case 'btn-add-edit':
				$('.add-edit-store-game-modal').modal('show');
				break;

		}

	});

	$(document).on('click', '.settings-icon', function () {
		$(".float-settings-menu").each(function (index) {
			$(this).toggleClass('menu-' + index)
		});
		$(".float-settings-icon").toggleClass('show-div');

	});
	$(document).on('click', '.sidebar-menu-btn', function () {
		$('.sidebar').toggleClass('sidebar-reponsive');
		$('.bg-div').toggle();
		pageSwitch = (pageSwitch == 0) ? 1 : 0;
	});

	$(document).on('click', '.dropdown-li', function () {
		$('.' + $(this).attr('id')).slideToggle('fast').removeClass('show-div');
	});

	$(document).on('click', '.sidebar-minimize', function () {
		localStorage.setItem("sidebar-active", (localStorage.getItem("sidebar-active") == "sidebar-yes") ? "sidebar-no" : "sidebar-yes");
		sidebarDiv();
	});

	$(document).on('click', '.sidebar-footer-img', function () {
		$('.div-img-logout-settings').toggle("fast");
	});

	$(document).on('click', function (event) {
		if (!$(event.target).is('.sidebar-footer-img, .div-img-logout-settings *')) {
			$('.div-img-logout-settings').hide("fast");
		}
		if (!$(event.target).is('.settings-icon, .float-settings-menu, .float-settings-icon')) {
			$(".float-settings-menu").each(function (index) {
				$(this).removeClass('menu-' + index)
			});
			$(".float-settings-icon").removeClass('show-div');
		}
		if (!$(event.target).is('.dropdown-inputbox, .dropdown-inputbox *, .dropdown-menu-div *')) {
			$('.dropdown-menu-div').hide();
		}
		if (!$(event.target).is('.ae-autocreation-available-btn, .ae-aad-icon, .ae-autocreation-available-div-content *')) {
			$('.ae-autocreation-available-div-content').fadeOut();
		}

		// if(!$(event.target).is('.ae-region-input, .dmd-region *')) {
		// 	$('.dmd-region').hide();
		// }
		// if(!$(event.target).is('.ae-edition-input, .dmd-edition *')) {
		// 	$('.dmd-edition').hide();
		// }
		// if(!$(event.target).is('.ae-ratings-input, .dmd-ratings *')) {
		// 	$('.dmd-ratings').hide();
		// }


	});

	// search modal section -----------------------------------------------------------

	switch (getUrlParameter('search')) {
		case 'true':
			$('#search-product-modal').modal('show');
			break;
	}


	$('#search-product-modal').on('hidden.bs.modal', function () {
		var getUrl = window.location.href;
		var getMatch = getUrl.match(/(\?|\&)([^=]+)\=([^&]+)/gm);

		if (getMatch == '?search=true') {
			var notCleanUrl = removeURLParameter(getUrl, 'search');
			var getClean = notCleanUrl.substr(notCleanUrl.length - 1);
			if (getClean == '?') getClean = notCleanUrl.substring(0, notCleanUrl.length - 1);
			var newurl = getClean;
		} else var newurl = removeURLParameter(getUrl, 'search');

		window.history.pushState({ path: newurl }, '', newurl);
	});

	$(document).on('click', '.header-search-btn', function () {
		var getUrl = window.location.href;
		var getMatch = getUrl.match(/(\?|\&)([^=]+)\=([^&]+)/gm);

		if (getMatch) {
			if (!getUrlParameter('search')) {
				var newurl = window.location.protocol + "//" + window.location.host + window.location.pathname + getMatch + "&search=true";
			}
		} else var newurl = window.location.protocol + "//" + window.location.host + window.location.pathname + "?search=true";

		window.history.pushState({ path: newurl }, '', newurl);
		$('#search-product-modal').modal('show');
	});

	$(document).on('click', '.search-product-modal-ddi', function () {
		switch ($(this).html()) {
			case 'AKS':
				var addBtnType = 'btn-success';
				break;
			case 'CDD':
				var addBtnType = 'btn-warning';
				break;
			case 'BREX':
				var addBtnType = 'btn-danger';
				break;
			default:
				var addBtnType = 'btn-primary';
				break;
		}
		$('.search-product-modal-dd-btn').removeClass('btn-primary btn-success btn-warning btn-danger').addClass(addBtnType).html($(this).html());
		if ($('.search-product-modal-txt').val() != '') mainSearchProduct($(this).html(), $('.search-product-modal-txt').val());
	});

	$(document).on('change', '.search-product-modal-txt', function () {
		var getSite = ($('.search-product-modal-dd-btn').html() == 'Select Site') ? 'AKS' : $('.search-product-modal-dd-btn').html();
		if ($(this).val() != '') mainSearchProduct(getSite, $(this).val());
		else {
			$('.spm-dialog').removeClass('spm-dialog-height spm-dialog-height-min spm-dialog-height-mid spm-dialog-height-max').addClass('spm-dialog-height');
			$('.spm-content-body').hide();
		}
	});

	$(document).on('click', '.spmc-dm-di', function () {
		$('.ae-addc-i-on-aks-1, .ae-addc-i-on-aks-0-2, .ae-addc-i-on-cdd-1, .ae-addc-i-on-cdd-0-2, .ae-addc-i-on-brex-1, .ae-addc-i-on-brex-0-2').empty();
		var getSite = ($('.search-product-modal-dd-btn').html() == 'Select Site') ? 'AKS' : $('.search-product-modal-dd-btn').html();
		callEdition();
		callRegion(getSite)
		toCreateDataArr = [];

		var dataRequest = {
			action: 'get-product-info',
			toGet: $(this).data('productid'),
			site: getSite
		}
		AjaxCall(url, dataRequest).done(function (data) {
			var data = data.data;

			$('.ae-product-p-title').html(getSite);
			$('.ae-merchant-input').val(data[0].merchant);
			$('.ae-search-name-input').val(data[0].search_name);
			// $('.ae-edition-input').val(data[0].edition);
			$('.ae-gameid-input').val(data[0].normalised_name);
			$('.ae-price-input').val(data[0].price);
			// $('.ae-region-input').val(data[0].region);
			$('.ae-ratings-input').val(data[0].rating);
			$('.ae-url-input').val(data[0].buy_url);
			$('.ae-keyword-input').val(data[0].keyword);
			$('.ae-category-input').val(data[0].category);
			$('.ae-buy-url-bis-input').val(data[0].buy_url_bis);
			$('.ae-buy-url-tier-input').val(data[0].buy_url_tier);
			$('.ae-release-date-input').val(data[0].releasedate);
			$('.ae-metacritic-score-input').val(data[0].metacritic_score);
			$('.ae-metacritic-critic-score-input').val(data[0].metacritic_critic_score);
			$('.ae-metacritic-user-score-input').val(data[0].metacritic_user_score);
			$('.ae-buy-url-4-input').val(data[0].buy_url_4);
			$('.ae-release-year-input').val(data[0].releaseyear);
			$('.ae-metacritic-count-input').val(data[0].metacritic_count);
			$('.ae-metacritic-critic-count-input').val(data[0].metacritic_critic_count);
			$('.ae-metacritic-user-count-input').val(data[0].metacritic_user_count);

			$('.ae-image-url-input').val(data[0].image_url);
			$('.ae-description-input').val(data[0].description);
			$('.ae-description-usa-or-eu-input').val(data[0].descriptionEuUsa);
			$('.ae-description-ru-input').val(data[0].descriptionRu);
			$('.ae-description-fr-input').val(data[0].descriptionFr);
			$('.ae-description-de-input').val(data[0].descriptionDe);
			$('.ae-description-es-input').val(data[0].descriptionEs);
			$('.ae-description-it-input').val(data[0].descriptionIt);
			$('.ae-description-pt-input').val(data[0].descriptionPt);
			$('.ae-description-nl-input').val(data[0].descriptionNl);

			getAvailable(data[0].merchant, '2') // default 2 for steam gloabl
		}).always(function () {
			$('.ae-to-what').html('create');
			$('.ae-modal-footer').empty().append('<button class="btn btn-primary mt-1" id="ae-btn-add">Create</button>')
			$('.add-edit-store-game-modal').modal('show');
		});
	});

	$(document).on('click', '.spmc-open-list-btn', function () {
		$('.displayProductByNormalisedName').modal('show');
		// alert($(this).data('normalisednameni'))
	});


	// add edit modal section -----------------------------------------------------------
	$(document).on('change', '.ae-merchant-input', function () {
		$('.ae-addc-i-on-aks-1, .ae-addc-i-on-aks-0-2, .ae-addc-i-on-cdd-1, .ae-addc-i-on-cdd-0-2, .ae-addc-i-on-brex-1, .ae-addc-i-on-brex-0-2').empty();
		toCreateDataArr = [];
		var getRegion = ($('.ae-region-input').val() == '') ? 2 : $('.ae-region-input').attr('data-regionid');
		getAvailable($(this).val(), getRegion)
	});

	$(document).on('click input', '.ae-edition-input', function () {
		$('.dropdown-menu-div').hide();
		$('.dmd-edition').show().empty();
		var getVal = $(this).val();


		var getOuput = saveEdition.filter(function (items) {
			return items.id.includes(getVal) || items.name.includes(getVal);
		});

		var displayTop = ['1', '16', '7', '5', '4', '33'];
		for (var i in getOuput) {
			if ($.inArray(getOuput[i].id, displayTop) != -1) {
				$('.dmd-edition').prepend(getOuput[i].toAppend)
			} else {
				$('.dmd-edition').append(getOuput[i].toAppend)
			}
		}
	});

	$(document).on('click', '.dmds-edition', function () {
		$('.ae-addc-i-on-aks-1, .ae-addc-i-on-aks-0-2, .ae-addc-i-on-cdd-1, .ae-addc-i-on-cdd-0-2, .ae-addc-i-on-brex-1, .ae-addc-i-on-brex-0-2').empty();
		$('.ae-edition-input').val($(this).data('nameni'));
		$('.ae-edition-input').attr('data-editionid', $(this).data('idni'));
		$('.dmd-edition').hide();
	});

	$(document).on('click input', '.ae-region-input', function () {
		$('.dropdown-menu-div').hide();
		$('.dmd-region').show().empty();
		var getVal = $(this).val();
		var getOuput = saveRegion.filter(function (items) {
			return items.id.includes(getVal) || items.name.includes(getVal);
		});

		for (var i in getOuput) {
			$('.dmd-region').append(getOuput[i].toAppend)
		}
	});

	$(document).on('click', '.dmds-region', function () {
		$('.ae-addc-i-on-aks-1, .ae-addc-i-on-aks-0-2, .ae-addc-i-on-cdd-1, .ae-addc-i-on-cdd-0-2, .ae-addc-i-on-brex-1, .ae-addc-i-on-brex-0-2').empty();
		$('.ae-region-input').val($(this).data('nameni'));
		$('.ae-region-input').attr('data-regionid', $(this).data('idni'));
		$('.dmd-region').hide();
		toCreateDataArr = [];

		getAvailable($('.ae-merchant-input').val(), $(this).data('idni'))
	});

	$(document).on('click', '.ae-ratings-input', function () {
		$('.dropdown-menu-div').hide();
		$('.dmd-ratings').show();
	});
	$(document).on('click', '.dmds-ratings', function () {
		$('.ae-ratings-input').val($(this).html());
		$('.dmd-ratings').hide();
	});

	$(document).on('click', '.ae-autocreation-available-btn', function () {
		$('.ae-autocreation-available-div-content').fadeToggle();
		$('.ae-aadc-includes').hide();
		$('.ae-addc-i-on-aks').show();

		// ae-addc-i-on-aks
		// display default
	});

	$(document).on('click', '.ae-aadc-li', function () {
		$('.ae-aadc-includes').hide();
		$('.' + $(this).attr('id')).show();
	});

	$(document).on('click', '#ae-btn-add', function () {
		$('.ae-addc-i-on-aks-1, .ae-addc-i-on-aks-0-2, .ae-addc-i-on-cdd-1, .ae-addc-i-on-cdd-0-2, .ae-addc-i-on-brex-1, .ae-addc-i-on-brex-0-2').empty();
		toCreateDataArr = [];
		var getRegion = ($('.ae-region-input').val() == '') ? 2 : $('.ae-region-input').attr('data-regionid');
		getAvailable($('.ae-merchant-input').val(), getRegion);

		var serialize = $('#ae-mcb-row :input').serializeArray();
		var formValues = {};
		for (var i in serialize) { formValues[serialize[i].name] = serialize[i].value }
		var dataRequest = {
			action: 'ae-create-action',
			formData: formValues,
			options: toCreateDataArr,
			source: $('.ae-product-p-title').text(),
		}
		console.log(dataRequest)
		AjaxCall(url, dataRequest).done(function (data) {
			console.log(data);
		}).always(function () { });
	});


}); // end docuemtn ready


function getMerchantsData() {
	let results = $.ajax({
		type: "GET", url: url + "app/getStores.json",
		async: false
	});
	return results.responseJSON;
}

function getVisible() {
	var dataRequest = {
		action: 'get-visible',
	}
	AjaxCall(url, dataRequest).done(function (data) {
		getVisibleArr = data;
	}).always(function () { });
}

function getAllowedRegion() {
	var dataRequest = {
		action: 'get-allowed-region',
	}
	AjaxCall(url, dataRequest).done(function (data) {
		getAllowedRegionsArr = data;
	}).always(function () { });
}

function getAvailable($merchantID, $region) {
	// NOTE :
	// 	0 = not available merchant
	// 	1 = available merchant
	// 	2 = not available region

	var getRarr = getAllowedRegionsArr[$region];
	var getAvailableData = JSON.parse($.ajax({ type: "GET", url: url + "vendors/txtfile/getAvailable.txt", async: false }).responseText);
	var getAvailableOutput = getAvailableData.filter(function (items) {
		return items.merchantID.includes("" + $merchantID + "")
	});

	// if exist for auto create
	if (getAvailableOutput[0] !== undefined) {
		// for auto create
		for (var i in getAvailableOutput[0]['merchantID']) {
			if (getAvailableOutput[0]['merchantID'][i]['url'] !== undefined) {
				$.each(getAvailableOutput[0]['merchantID'][i]['url'], function (index, value) {
					var inputUrl = $('.ae-url-input').val();
					var getVarr = getVisibleArr[index];
					var replacedString = inputUrl.match(new RegExp(getAvailableOutput[0]['merchantID'][i]['toReplaceRegex']), value);
					var geturl = (replacedString != null) ? inputUrl.replace(replacedString[1], value) : inputUrl;
					getAvailableToCreate(getVarr, getRarr, $region, index, geturl);
				});
			}
		}
	} else {
		// no auto create
		var getVarr = getVisibleArr[$merchantID];
		getAvailableToCreate(getVarr, getRarr, $region, $merchantID, $('.ae-url-input').val());
	}
}

function getAvailableToCreate($getArr, $getRegionArr, $getRegion, $getMerchantID, $getUrl) {
	for (var i in $getArr) {
		var replaceUnderScoreVal = i.replaceAll("_", ".");
		if ($getArr[i] == 1) {
			if ($.inArray(replaceUnderScoreVal, $getRegionArr) != -1) {
				createSwitchForAvailable(replaceUnderScoreVal, 1, $getRegion, $getMerchantID);
				toCreateDataArr.push({
					'merchantID': $getMerchantID,
					'url': updateCurrency(replaceUnderScoreVal, $getUrl),
					'region': $getRegion,
					'site': getOriginalSite(replaceUnderScoreVal)
				});
			} else {
				createSwitchForAvailable(replaceUnderScoreVal, 2, $getRegion, $getMerchantID);
			}
		} else {
			createSwitchForAvailable(replaceUnderScoreVal, 0, $getRegion, $getMerchantID);
		}
	}
}

function updateCurrency($partial, $partialUrl) {
	switch ($partial) {
		case 'allkeyshop.com':
			var updateUrl = $partialUrl;
			updateUrl = updateUrl.replace('=USD', '=EUR');
			updateUrl = updateUrl.replace('=GBP', '=EUR');

			updateUrl = updateUrl.replace('=usd', '=eur');
			updateUrl = updateUrl.replace('=gbp', '=eur');
			break;
		case 'reviewitusa':
			var updateUrl = $partialUrl;
			updateUrl = updateUrl.replace('=EUR', '=USD');
			updateUrl = updateUrl.replace('=GBP', '=USD');

			updateUrl = updateUrl.replace('=eur', '=usd');
			updateUrl = updateUrl.replace('=gbp', '=usd');
			break;
		case 'allkeyshop.com.gbp':
			var updateUrl = $partialUrl;
			updateUrl = updateUrl.replace('=EUR', '=GBP');
			updateUrl = updateUrl.replace('=USD', '=GBP');

			updateUrl = updateUrl.replace('=eur', '=gbp');
			updateUrl = updateUrl.replace('=usd', '=gbp');
			break;
	}
	return updateUrl;
}

function getOriginalSite($partial) {
	switch ($partial) {
		case 'allkeyshop.com':
			$site = 'AKS';
			break;
		case 'reviewitusa':
			$site = 'CDD';
			break;
		case 'allkeyshop.com.gbp':
			$site = 'BREX';
			break;
	}

	return $site;
}
function createSwitchForAvailable($getVisible, $available, $region, $merchantID) {
	switch ($getVisible) {
		case 'allkeyshop.com':
			var whatBox = 'ae-addc-i-on-aks-1';
			var whatNotAvail = 'ae-addc-i-on-aks-0-2';
			var toAppend = createCheckbox($available, 'forAKS', $region, 'AKS', $merchantID);
			break;
		case 'reviewitusa':
			var whatBox = 'ae-addc-i-on-cdd-1';
			var whatNotAvail = 'ae-addc-i-on-cdd-0-2';
			var toAppend = createCheckbox($available, 'forCDD', $region, 'CDD', $merchantID);
			break;
		case 'allkeyshop.com.gbp':
			var whatBox = 'ae-addc-i-on-brex-1';
			var whatNotAvail = 'ae-addc-i-on-brex-0-2';
			var toAppend = createCheckbox($available, 'forBrex', $region, 'BREXIT', $merchantID);
			break;
	}

	if ($available == 1) $('.' + whatBox).append(toAppend);
	else $('.' + whatNotAvail).append(toAppend);
}

function createCheckbox($available, $checkboxName, $checkboxRegion, $whatSite, $merchantID) {
	// NOTE :
	// 	0 = Merchant is not visible for creation
	// 	1 = Merchant is visible and Region is Allowed
	// 	2 = Merchant is visible but region is not allowed
	var merchantName = (merchantsHolder[$merchantID] !== undefined) ? merchantsHolder[$merchantID]['name1'] : 'Name Not Found';
	switch ($available) {
		case 0:
			var toAppend = '<span class="text-danger">Merchant <b>' + merchantName +' '+$merchantID+ '</b> is not Visible on <b>' + $whatSite + '</b></span><br>';
			break;

		case 1:
			var toAppend = '<div class="form-check text-primary" data-getid="' + $merchantID + '">';
			toAppend += '	<input class="form-check-input" name="' + $checkboxName + '" type="checkbox" value="" id="' + $checkboxName + $checkboxRegion + '">';
			toAppend += '	<label class="form-check-label" for="' + $checkboxName + $checkboxRegion + '">';
			toAppend += '		Merchant <b>' + merchantName + ' ' + $merchantID + '</b> is Visible on <b class="text-primary">' + $whatSite + '</b> and region <b>' + $checkboxRegion + '</b>  is allowed';
			toAppend += '	</label>';
			toAppend += '</div>';
			break;

		case 2:
			var toAppend = '<span class="text-danger">Merchant <b>' + merchantName + ' ' + $merchantID + '</b> is Visible on <b>' + $whatSite + '</b> but Region <b>' + $checkboxRegion + '</b> is not allowed</span><br>';
			break;

		default: var toAppend = '<span> <b>Somthing went wrong!!</b> </span>';
			break;
	}
	return toAppend;
}

function callEdition() {
	saveEdition = []
	var dataRequest = {
		action: 'get-edition',
	}
	AjaxCall(url, dataRequest).done(function (data) {
		for (var i in data) {
			saveEdition.push({
				'id': data[i].id,
				'name': data[i].name.toLowerCase(),
				'toAppend': '<div class="dropdown-menu-div-sub dmds-edition" data-nameni="' + data[i].name.toLowerCase() + '" data-idni=' + data[i].id + '><span class="dmds-data-name">' + data[i].name.toLowerCase() + '</span> = <span class="dmds-data-id"> ' + data[i].id + ' </span></div>'
			});
		}
	}).always(function () { });
}
function callRegion($site) {
	saveRegion = []
	var dataRequest = {
		action: 'get-region',
		site: $site
	}
	AjaxCall(url, dataRequest).done(function (data) {
		for (var i in data) {
			if ($site == 'CDD') {
				var excluded = [
					'80latam',
					'3latam',
					'1latam',
					'154',
					'steangiftlatam',
					'steamlatam',
					'uplaylatam'
				];

				if ($.inArray(data[i].id, excluded) === -1) {
					if (!(data[i].name).match(/(AUS|EU|EMEA|Uplay EMEA)/)) {
						if ((data[i].name).match(/(US|LATAM|NA|xbox)/i)) {
							saveRegion.push({
								'id': data[i].id,
								'name': data[i].name.toLowerCase(),
								'toAppend': '<div class="dropdown-menu-div-sub dmds-region" data-nameni="' + data[i].name.toLowerCase() + '" data-idni=' + data[i].id + '><span class="dmds-data-name">' + data[i].name.toLowerCase() + '</span> = <span class="dmds-data-id"> ' + data[i].id + ' </span></div>'
							});
						}
					}
				}
			} else {
				var excluded = ['129', '2573'];

				if ($.inArray(data[i].id, excluded) === -1) {
					if (!(data[i].name).match(/(LATAM|RU|APAC|ASIA|STEAM GIFT NA| US |Epic Store US|GOG US|Origin US)/i)) {
						saveRegion.push({
							'id': data[i].id,
							'name': data[i].name.toLowerCase(),
							'toAppend': '<div class="dropdown-menu-div-sub dmds-region" data-nameni="' + data[i].name.toLowerCase() + '" data-idni=' + data[i].id + '><span class="dmds-data-name">' + data[i].name.toLowerCase() + '</span> = <span class="dmds-data-id"> ' + data[i].id + ' </span></div>'
						});
					}

				}
			}
		}
	}).always(function () { });
}


function mainSearchProduct($site, $toSearch) {
	$('.spm-content-display, .spmc-dm').empty();
	$('.spmc-loader-wrapper').slideDown();

	var dataRequest = {
		action: 'main-search-product',
		toSearch: $toSearch,
		site: $site
	}

	AjaxCall(url, dataRequest).done(function (data) {
		var checkUnique = [];
		for (var i in data) {
			var append = '<div class="spmc-display-content-wrapper">';
			append += '<div class="spmc-dcw-btn-div"><button class="btn btn-info spmc-open-list-btn" data-normalisednameni=' + data[i].normalised_name + '>Open list</button></div>';
			append += '<div class="spmc-dcw-merchant-div">' + data[i].vols_nom + '</div>';
			append += '<div class="spmc-dcw-url-div">' + data[i].buy_url + '</div>';
			append += '</div>';

			if ($.inArray(data[i].vols_nom, checkUnique) == -1) {
				checkUnique.push(data[i].vols_nom);
				$('.spmc-dm').append('<span class="dropdown-item spmc-dm-di" data-merchantni=' + data[i].merchant + ' data-productid=' + data[i].id + ' data-productnormalisename=' + data[i].normalised_name + '>' + data[i].vols_nom + '</span>')
			}
			$('.spm-content-display').append(append);
		}
	}).always(function (data) {
		$('.spmc-loader-wrapper').hide();
		$('.spm-content-body').show();
		$('.spmc-span-site').html($site)

		if (data.length == 0) {
			$('.spmc-display-header-span-what').html("No product found in ");
			$('.spmc-btn').hide();
			$('.spmc-request-id-btn').show();
		} else {
			if (data.length > 1 && data.length < 4) $('.spm-dialog').removeClass('spm-dialog-height spm-dialog-height-min spm-dialog-height-mid spm-dialog-height-max').addClass('spm-dialog-height-min');
			if (data.length > 4 && data.length < 7) $('.spm-dialog').removeClass('spm-dialog-height spm-dialog-height-min spm-dialog-height-mid spm-dialog-height-max').addClass('spm-dialog-height-mid');
			if (data.length >= 7) $('.spm-dialog').removeClass('spm-dialog-height spm-dialog-height-min spm-dialog-height-mid spm-dialog-height-max').addClass('spm-dialog-height-max');

			// console.log(data.length)
			$('.spmc-display-header-span-what').html("Product found in ");
			$('.spmc-btn').hide();
			$('.spmc-btn-merchant-create').show();
		}
	});
}

function removeEmptyTitle() {
	var items = $('body').find('.header-title');
	$.each(items, function (i, v) {
		if ($(items[i]).html().trim() === "") {
			$(items[i]).remove();
		}
	});
}

// dashboard function here -----------------------------------
function displayIcon() {
	var iconList = [
		"fa-chart-pie",
		// "fa-clipboard",
		"fa-link",
		"fa-podcast",
		"fa-store-alt",
		"fa-tools",
		"fa-power-off"
	];

	$('i#nav-icon').each(function (i) {
		$(this).addClass(iconList[i])
	});
}


// ajax call function ---------------------------------------
function AjaxCall($url, $data) {
	// NOTE: 
	// 	done = success
	// 	always = complete

	return $.ajax({
		url: $url,
		type: "POST",
		data: $data
	})
}
//$getInput = $getInput->get(); //use this get all data sent 
//$var = $getInput['site'];  //var sent {'site':$aks} 
function _ajaxCall($url, $type, $action, $data) {
	return $.ajax({
		url: $url,
		type: $type,
		data: {
			action: $action,
			data: $data
		}
	})
}
function _ajaxCall_01($url, $type, $data) {
	return $.ajax({
		url: $url,
		type: $type,
		data: $data
	})
}

// custom function here -------------------------------------
function scrollThis() {
	switch (localStorage.getItem("sidebar-active")) {
		case 'sidebar-yes':
			if (scroll >= 220) {
				if (localStorage.getItem("body-mode") == 'darkmode') {
					$('.header-content-stickey').css({ 'background': 'rgba(39, 41, 61, 1)' });
				} else {
					$('.header-content-stickey').css({ 'background': 'rgba(255, 255, 255, 1)' });
				}

				$('.header-content').addClass('header-content-stickey minimized-sb-sticky-header');
				$('.breadcrumbs-ul').addClass('breadcrumbs-ul-fixed ' + $('.dropdown-menu-btn').text() + '-sticky-BGC breadcrumbs-ul-stickey minimized-sb-sticky');
				$('.store-page-search.form-control').addClass('minimized-sb-sticky');
				$('.breadcrumbs-arrow').addClass('breadcrumbs-arrow-rezise breadcrumbs-ul-stickey');
				$('.sticky-dropdown').show();
				$('.store-page-search').addClass('store-page-search-sticky');
				$('.store-search-btn').addClass('store-search-btn-sticky');

				if ($(window).width() <= 768) {
					$('.header-content').removeClass('minimized-sb-sticky-header');
					$('.breadcrumbs-ul').removeClass('minimized-sb-sticky');
					$('.store-page-search.form-control').removeClass('minimized-sb-sticky');
				}
			} else {
				$('.header-content-stickey').css({ 'background': 'transparent' });
				$('.header-content').removeClass('header-content-stickey minimized-sb-sticky-header');
				$('.breadcrumbs-ul').removeClass('breadcrumbs-ul-fixed breadcrumbs-ul-stickey minimized-sb-sticky ' + $('.dropdown-menu-btn').text() + '-sticky-BGC AKS-sticky-BGC CDD-sticky-BGC BREX-sticky-BGC');
				$('.breadcrumbs-arrow').removeClass('breadcrumbs-arrow-rezise breadcrumbs-ul-stickey');
				$('.sticky-dropdown').hide();
				$('.store-page-search').removeClass('store-page-search-sticky');
				$('.store-search-btn').removeClass('store-search-btn-sticky');
			}
			break;
		case 'sidebar-no':
			if (scroll >= 220) {
				if (localStorage.getItem("body-mode") == 'darkmode') {
					$('.header-content-stickey').css({ 'background': 'rgba(39, 41, 61, 1)' });
				} else {
					$('.header-content-stickey').css({ 'background': 'rgba(255, 255, 255, 1)' });
				}

				$('.header-content').addClass('header-content-stickey');
				$('.breadcrumbs-ul').addClass('breadcrumbs-ul-fixed ' + $('.dropdown-menu-btn').text() + '-sticky-BGC breadcrumbs-ul-stickey');
				$('.breadcrumbs-arrow').addClass('breadcrumbs-arrow-rezise breadcrumbs-ul-stickey');
				$('.sticky-dropdown').show();
				$('.store-page-search').addClass('store-page-search-sticky');
				$('.store-search-btn').addClass('store-search-btn-sticky');
			} else {
				$('.header-content-stickey').css({ 'background': 'transparent' });
				$('.header-content').removeClass('header-content-stickey minimized-sb-sticky-header');
				$('.breadcrumbs-ul').removeClass('breadcrumbs-ul-fixed ' + $('.dropdown-menu-btn').text() + '-sticky-BGC AKS-sticky-BGC CDD-sticky-BGC BREX-sticky-BGC breadcrumbs-ul-stickey');
				$('.breadcrumbs-arrow').removeClass('breadcrumbs-arrow-rezise breadcrumbs-ul-stickey');
				$('.sticky-dropdown').hide();
				$('.store-page-search').removeClass('store-page-search-sticky minimized-sb-sticky');
				$('.store-search-btn').removeClass('store-search-btn-sticky');
			}
			break;
	}
}

// sidebar function ------------------------------------
function sidebarDiv() {
	var cssvar = '.sidebar-menu-value, .li-nav-dd, .sidebar-footer-welcome, .sidebar-footer-name, .sidebar-footer-logout-icon';
	if (toggleVal == 0) {
		$(cssvar).hide();
		$('.sidebar-logo-img-1').hide();
		$('.li-nav-dd-mini').delay(200).fadeIn();
		$('.sidebar-logo-img-2').fadeIn();
		$('.sidebar-minimize-icon').removeClass('fa-angle-double-left').addClass('fa-angle-double-right');
		$('.sidebar-minimize').css({ 'background': 'linear-gradient(60deg, #004ea3, #0062cc)', 'color': '#fff' });
		toggleVal = 1;
	} else {
		$(cssvar).fadeIn(600);
		$('.sidebar-logo-img-2, .li-nav-dd-mini').hide();
		$('.sidebar-logo-img-1').fadeIn(1000);
		$('.sidebar-minimize-icon').removeClass('fa-angle-double-right').addClass('fa-angle-double-left');
		$('.sidebar-minimize').css({ 'background': '#fff', 'color': '#6b6d70' });

		toggleVal = 0;
	}

	$('.sidebar, .sidebar-content-wrapper').toggleClass('minimize-sidebar');
	$('.sidebar-logo, .sidebar-menu').toggleClass('text-center');
	$('.sidebar-menu-icon').toggleClass('nav-resize');
	$('.sidebar-footer-img').toggleClass('footer-image-center');
	$('.sidebar-footer-online-dot').toggleClass('d-none');
	$('.sidebar-minimize-icon').toggleClass('sidebar-minimize-icon-recode');
	$('.sub-li-nav-div-span-icon').toggleClass('sub-li-nav-div-span-icon-resize');
	$('.sidebar-menu').toggleClass('sidebar-menu-resize');
	$('.div-img-logout-settings').toggleClass('div-img-logout-settings-recode');
	$('.header-content-footer').toggleClass('header-content-footer-recode');

	if (pageSwitch == 0) {
		switch (localStorage.getItem("sidebar-active")) {
			case 'sidebar-yes':
				if (scroll >= 220) {
					$('.header-content').addClass('header-content-stickey minimized-sb-sticky-header');
					$('.breadcrumbs-ul').addClass('breadcrumbs-ul-fixed ' + $('.dropdown-menu-btn').text() + '-sticky-BGC breadcrumbs-ul-stickey minimized-sb-sticky');
					$('.store-page-search.form-control').addClass('minimized-sb-sticky');
					$('.breadcrumbs-arrow').addClass('breadcrumbs-arrow-rezise breadcrumbs-ul-stickey');
				}
				break;
			case 'sidebar-no':
				if (scroll >= 220) {
					$('.header-content').removeClass('minimized-sb-sticky-header');
					$('.breadcrumbs-ul').removeClass('minimized-sb-sticky');
					$('.store-page-search').removeClass('minimized-sb-sticky');
					$('.store-page-search.form-control').removeClass('minimized-sb-sticky');
				}
				break;
		}
	}
}

function displayMode($mode) {
	switch ($mode) {
		case 'darkmode':
			$('.header-content-stickey').css({ 'background': 'rgba(39, 41, 61, 1)' });
			$(".main-word").attr("src", url + "vendors/image/logo-word-darkmode.png");
			$(".main-logo").attr("src", url + "vendors/image/logo-black-darkmode.png");

			$(".li-nav-div, .sub-li-nav-div").removeClass('li-nav-and-sub-normal').addClass("li-nav-and-sub-darkmode");
			$('.sub-li-nav-div:hover').css({ 'background': '#1f2030' });
			$('.sidebar-content-wrapper').removeClass('sidebar-content-wrapper-normal').addClass('sidebar-content-wrapper-darkmode');
			$('.sidebar-menu-value').removeClass('sidebar-menu-value-normal').addClass('sidebar-menu-value-darkmode');
			$('.sidebar-footer').removeClass('sidebar-footer-normal').addClass('sidebar-footer-darkmode');
			$('.hcf-back').removeClass('hcf-back-normal').addClass('hcf-back-darkmode');
			$('.card').removeClass('card-normalmode').addClass('card-darkmode');
			$('.header-title').removeClass('header-title-normal').addClass('header-title-darkmode');
			$('.card-title-p').removeClass('card-title-p-normal').addClass('card-title-p-darkmode');
			$('.card-val-p').removeClass('card-val-p-normal').addClass('card-val-p-darkmode');
			$('.card-val-p-sub').removeClass('card-val-p-sub-normal').addClass('card-val-p-sub-darkmode');
			$('.card-header').addClass('card-header-darkmode');
			$('html, body').addClass('html-body-darkmode');
			$(".bulletin-content").removeClass('content-normalmode').addClass("content-darkmode");
			$(".bulletin-sub-content").removeClass('sub-content-normalmode').addClass("sub-content-darkmode");

			$('.store-games-data-table-tbody-data').removeClass('store-games-data-table-tbody-data-normal').addClass('store-games-data-table-tbody-data-darkmode')

			//report page
			$('.pltb-report, .problem-lis-tab-btn, .hide-extra, .pltb-completed, .td-1st-child').removeClass('normal-mode').addClass('dark-mode');
			// $('.problem-lis-tab-btn').removeClass('problem-lis-tab-btn-normal').addClass('problem-lis-tab-btn-darkmode');

			localStorage.setItem("body-mode", 'darkmode');
			$(".switch-checkbox").prop("checked", true);

			break;
		case 'normal':
			$(".main-word").attr("src", url + "vendors/image/logo-word.png");
			$(".main-logo").attr("src", url + "vendors/image/logo-black.png");

			$(".li-nav-div, .sub-li-nav-div").removeClass('li-nav-and-sub-darkmode').addClass("li-nav-and-sub-normal");
			$('.header-content-stickey').css({ 'background': 'rgba(255, 255, 255, 1)' });
			$('.sidebar-content-wrapper').removeClass('sidebar-content-wrapper-darkmode').addClass('sidebar-content-wrapper-normal');
			$('.sidebar-menu-value').removeClass('sidebar-menu-value-darkmode').addClass('sidebar-menu-value-normal');
			$('.sidebar-footer').removeClass('sidebar-footer-darkmode').addClass('sidebar-footer-normal');
			$('.hcf-back').removeClass('hcf-back-darkmode').addClass('hcf-back-normal');
			$('.card').removeClass('card-darkmode').addClass('card-normalmode');
			$('.header-title').removeClass('header-title-darkmode').addClass('header-title-normal');
			$('.card-title-p').removeClass('card-title-p-darkmode').addClass('card-title-p-normal');
			$('.card-val-p').removeClass('card-val-p-darkmode').addClass('card-val-p-normal');
			$('.card-val-p-sub').removeClass('card-val-p-sub-darkmode').addClass('card-val-p-sub-normal');
			$('.card-header').removeClass('card-header-darkmode');
			$('html, body').removeClass('html-body-darkmode');
			$(".bulletin-content").removeClass('content-darkmode').addClass("content-normalmode");
			$(".bulletin-sub-content").removeClass('sub-content-darkmode').addClass("sub-content-normalmode");

			$('.store-games-data-table-tbody-data').removeClass('store-games-data-table-tbody-data-darkmode').addClass('store-games-data-table-tbody-data-normal')

			//report page
			$('.pltb-report, .problem-lis-tab-btn, .hide-extra, .pltb-completed, .td-1st-child').removeClass('dark-mode').addClass('normal-mode');

			localStorage.setItem("body-mode", 'normal');
			$(".switch-checkbox").prop("checked", false);
			break;
	}
}


function html_decode(string) {
	return String(string).replace(/[&<>"'`=\/¤]/g, function (s) {
		return entityMap[s];
	});
}

function regExpEscape(literal_string) {
	return literal_string.replace(/[-[\]{}()*+!<=:?.\/\\^$|#\s,]/g, '\\$&');
}

function debounce(fun, mil) {
	var timer;
	return function () {
		clearTimeout(timer);
		timer = setTimeout(function () {
			fun();
		}, mil);
	};
}

function safelyParseJSON(json) {
	var parsed = null;
	try {
		parsed = JSON.parse(json)
	} catch (e) {
		// do stuff here
	}
	return parsed;
}
function returnSite($site = null) {
	try {
		switch ($site) {
			case 'aks': $site;
				break;
			case 'cdd': $site;
				break;
			case 'brexitgbp': $site;
				break;
			default: $site = null;
				break
		}
	} catch (error) { }
	return $site;
}
function setStorage($type, $key, $value) {
	var $return = true;
	try {
		if (typeof (Storage) !== "undefined") {
			switch ($type) {
				case 'localStorage': localStorage.setItem($key, $value);
					break;
				case 'sessionStorage': sessionStorage.setItem($key, $value);
					break;
				default: break;
			}
		}
	} catch (e) {
		$return = false
	}
	return $return;
}
function getStorage($type, $key) {
	var $item = null;
	try {
		if ((typeof (Storage) !== "undefined")) {
			switch ($type) {
				case 'localStorage': $item = localStorage.getItem($key);
					break;
				case 'sessionStorage': $item = sessionStorage.getItem($key);
					break;
				default: break;
			}
		}
	} catch (error) { }
	return $item;
}

function removeExistingItem($type, $key, $path) {
	//$path is path of the utilities page u can use uri variable
	//use this to remove existing key 
	// if (!removeExistingItem('sessionStorage','OptionSite',uri)){
	// 		console.log('Item has been removed');
	// 	}
	switch ($type) {
		case 'localStorage':
			var object = safelyParseJSON(localStorage.getItem($key));
			if (object === null) return true;
			else if ($path == object.path) return true;
			else if ($path != object.path) {
				localStorage.removeItem($key);
				return false;
			}
			break;
		case 'sessionStorage':
			var object = safelyParseJSON(sessionStorage.getItem($key));
			if (object === null) return true;
			else if ($path == object.path) return true;
			else if ($path != object.path) {
				sessionStorage.removeItem($key);
				return false;
			}
			break;
		default: return true;
			break;
	}
}

function removedKeyNormal($type, $key) {
	var $bool = true;
	try {
		if (typeof (Storage) !== "undefined") {
			switch ($type) {
				case 'localStorage': localStorage.removeItem($key);
					break;
				case 'sessionStorage': sessionStorage.removeItem($key);
					break;
			}
		}
	} catch (error) {
		$bool = false;
	}
	return $bool;
}

function getUrlParameter(name) {
	name = name.replace(/[\[]/, '\\[').replace(/[\]]/, '\\]');
	var regex = new RegExp('[\\?&]' + name + '=([^&#]*)');
	var results = regex.exec(location.href);
	return results === null ? '' : decodeURIComponent(results[1].replace(/\+/g, '    '));
};

function changeUrlParameter($param) {
	var newurl = window.location.protocol + "//" + window.location.host + window.location.pathname + $param;
	window.history.pushState({ path: newurl }, '', newurl);
}

function removeURLParameter(url, parameter) {
	//prefer to use l.search if you have a location/link object
	var urlparts = url.split('?');
	if (urlparts.length >= 2) {

		var prefix = encodeURIComponent(parameter) + '=';
		var pars = urlparts[1].split(/[&;]/g);

		//reverse iteration as may be destructive
		for (var i = pars.length; i-- > 0;) {
			//idiom for string.startsWith
			if (pars[i].lastIndexOf(prefix, 0) !== -1) {
				pars.splice(i, 1);
			}
		}
		url = urlparts[0] + '?' + pars.join('&');
		return url;
	} else {
		return url;
	}
}

function confirmationModal($appendtoheader, $appendtobody, $appendtofooter) {
	$('#report-modal-confirmation').modal('show');
	$('.confirmation-tittle').empty().html($appendtoheader);
	$('.modal-content-body').empty().append($appendtobody)
	$('.confirmation-modal-footer').empty().append($appendtofooter)
}

function alertMsg($msg) {
	$('#alert-modal').modal('show');
	$('.alert-modal-msg').empty().append($msg);
	setTimeout(function () {
		$('#alert-modal').modal('hide');
	}, 2000);
}

function returnSiteClass($site) {
	switch ($site) {
		case 'AKS': case 'aks':
			var $class = 'aks_bg_color';
			break;
		case 'CDD': case 'cdd':
			var $class = 'cdd_bg_color';
			break;
		case 'BREX': case 'brex': case 'BREXITGBP': case 'brexitgbp':
			var $class = 'brexit_bg_color';
			break;

		default: var $class = 'aks_bg_color';
			break;
	}
	return $class;
}
function eRegex($string) {
	switch ($string) {
		case '+': case '-': case '*': case '/': case '?': case '^': case '|':
			$string = "\/" + $string;
			break;
		default:
			break;
	}
	return $string;
}

function displayStoreGamesByNormalizedName($normalised_name, $site) {
	var dataRequest = {
		action: 'displayStoreGamesByNormalizedName',
		nnameID: $normalised_name,
		site: $site
	}

	AjaxCall(url, dataRequest).done(function (data) {
		$('.productName').text(data[0].searchName);
		$('.productNormalizedName').text(data[0].nname);
		$('#displayStoreGamesByNormalizedName').modal('show');
		$('.nname-modal-tbody').empty();
		//console.log(data);
		for (var i in data) {
			var append = '<div class="nname-modal-tbody-div ' + data[i].id + '">';
			append += '<div class="modal-child-tbody-1">' + data[i].merchant + '</div>';
			append += '<div class="modal-child-tbody-2">' + data[i].region + '</div>';
			append += '<div class="modal-child-tbody-3">' + data[i].edition + '</div>';
			append += '<div class="modal-child-tbody-sub modal-child-tbody-4"><input class="modal-val-btn" type="button" 	data-prodId="' + data[i].id + '" 	value="' + data[i].status + '"></div>';
			append += '<div class="modal-child-tbody-sub modal-child-tbody-5"><input id="price-update" class="modal-val-txt" type="number" 	data-prodId="' + data[i].id + '"	value="' + data[i].price + '"></div>';
			append += '<div class="modal-child-tbody-sub modal-child-tbody-6">';
			append += '<div class="show-menu" id="' + data[i].id + '">';
			append += '<ul class="modal-setting-ul">';
			append += '<li class="modal-setting-ul-li"><i class="fa fa-pencil" aria-hidden="true"></i><span class="msulspan add-edit-from-display" data-toeditid="' + data[i].id + '">Edit</span></li>';
			append += '<li class="modal-setting-ul-li"><i class="fa fa-times" aria-hidden="true"></i><span class="msulspan">Delete</span></li>';
			append += '<li class="modal-setting-ul-li"><i class="fa fa-dot-circle-o" aria-hidden="true"></i><span class="msulspan">Others</span></li>';
			append += '</ul>';
			append += '</div>';
			append += '<button class="btn action-btn ' + data[i].site + '-btn" id="' + data[i].id + '"> <i class="fa fa-cogs btn-icon-acb" aria-hidden="true"></i></button>';
			append += '</div>';
			append += '<div><p class="nname-modal-tfoot"><a href="' + data[i].buy_url + '" target="_blank">' + html_decode(data[i].buy_url) + '</a></p></div>';
			append += '</div>';
			$(".nname-modal-tbody").append(append);
		}
	});
}
