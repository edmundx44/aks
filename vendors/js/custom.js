var toggleVal = 0;
var sidebarDisplay = (localStorage.getItem("sidebar-active") == "sidebar-yes") ? sidebarDiv() : '';
var clickState = 0;
var docHeight = $(document).height();
var docWidth = $(document).width();
var $div = $('#float-anywhere');
var divWidth = $div.width();
var divHeight = $div.height();
var heightMax = 800 - divHeight;
var widthMax = docWidth - divWidth;
var scroll = '';
var pageSwitch = 0;
var toClose = '';
var d = new Date();
var month = d.getMonth() + 1;
var day = d.getDate();
var crProblemArr = [];
var saveRegion = [];
var saveEdition = [];
var getVisibleArr = [];
var getAllowedRegionsArr = [];
var toCreateDataArr = [];
var queryString = window.location.search;
var uri = window.location.pathname;

$div.css({
	left: Math.floor(Math.random() * widthMax),
	top: Math.floor(Math.random() * heightMax)
});

//Autocreation Excluded Special Case
/*----------------------------------------------------*/
const merchantExc = ["125", "1252", "1253", "1254"];

/*---------------------------------------------------*/
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
	

	// var pathname = window.location.pathname;     
	// var origin   = window.location.origin;
	// var url      = window.location.href; 
	// localStorage.clear();
	
	// active parameter -----------------------------------------------------------------
	if (getUrlParameter('search') == 'true') {
		$('#search-product-modal').modal('show');
	}

	if (getUrlParameter('normalisedname')) {
		var getNormalizedName = (getUrlParameter('normalisedname') == 'true') ? "" : getUrlParameter('normalisedname');

		$('.dpbnm-product-nname').val(getNormalizedName)
		$('.display-product-by-normalised-input').val('AKS')
		$('.display-product-by-normalised-input').attr('data-product-website', 'AKS') //used for delete
		$('.displayProductByNormalisedName').modal('show')
		getByNormalisedName(getUrlParameter('normalisedname'), $('.display-product-by-normalised-input').val())
	}
	// end active parameter -------------------------------------------------------------

	// modal dragable and component
	$('[data-toggle="tooltip"]').tooltip();

	$('.modal-dialog').draggable({
		handle: ".modal-content",
		cancel: 'span, input, .nfof-feedback, .pc-asb-modal*, .modal-content-body*, .spm-content-body*'
	});

	$("#float-anywhere").draggable({});
	// end modal dragable and component

	// windows component ----------------
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
	// end windows component -------------

	$(document).on('click', '.dropdown-website', function () { $(this).find('.website-menu').slideToggle(200); });

	$(document).keydown(function (event) {
		if (event.which === 27) {
			// esc
			//$('.modal').modal('hide');
		} else if ((event.which === 51 && event.altKey)) {
			//show add edit modal
			// alt + 3
			$('.modal').modal('hide');
			$('.add-edit-store-game-modal').modal('show');
		} else if ((event.which === 53 && event.altKey)) {
			// change mode dark or normal
			// alt + 5
			$('.switch-checkbox').trigger('click');
		} else if ((event.which === 65 && event.altKey)) {
			// redirect to activity logs
			// alt + a
			window.location.href = "" + url + "dashboard/activities";
		} else if ((event.which === 82 && event.altKey)) {
			// show create report modal
			// alt + r
			crProblemArr = [];
			$('.modal').modal('hide');
			$('#createReportModal').modal('show');
		} else if ((event.which === 49 && event.altKey)) {
			// show search product modal
			// alt + 1
			$('.modal').modal('hide');
			$('.header-search-btn').trigger('click');
		} else if ((event.which === 50 && event.altKey)) {
			// show search by normalised name modal
			// alt + 2
			$('.modal').modal('hide');
			setUrlParam('normalisedname', '');
			$('.display-product-by-normalised-input').val('AKS');
			$('.display-product-by-normalised-input').attr('data-product-website', 'AKS')//used for delete
			$('.dpbnm-product-nname').val('');
			$('.dpbnm-table-body').empty();
			$('.displayProductByNormalisedName').modal('show');
		}
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
			$(this).toggleClass('menu-' + index);
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
				$(this).removeClass('menu-' + index);
			});
			$(".float-settings-icon").removeClass('show-div');
		}
		if (!$(event.target).is('.dropdown-inputbox, .dropdown-inputbox *, .dropdown-menu-div *')) {
			$('.dropdown-menu-div').hide();
		}
		if (!$(event.target).is('.ae-autocreation-available-btn, .ae-aad-icon, .ae-autocreation-available-div-content *')) {
			$('.ae-autocreation-available-div-content').fadeOut();
		}
		if (!$(event.target).is('.dpbnm-product-action, .dpbnm-product-action-div *')) {
			$('.dpbnm-product-action-div').hide();
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
	$('#search-product-modal').on('hidden.bs.modal', function () { unsetUrlParam('search') });
	$('.displayProductByNormalisedName').on('hidden.bs.modal', function () { unsetUrlParam('normalisedname') });

	$(document).on('click', '.spmc-display-content-wrapper', function () {
		var selection = window.getSelection();
		if(selection.type != "Range") {
			var getSite = ($('.search-product-modal-dd-btn').html() == 'Select Site') ? 'AKS' : $('.search-product-modal-dd-btn').html();
			displayOnAddEditModal($(this).data('productid'), getSite, 'create');
		}
	});

	$(document).on('click', '.header-search-btn', function () {
		setUrlParam('search', '');
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
		var getSite = ($('.search-product-modal-dd-btn').html() == 'Select Site') ? 'AKS' : $('.search-product-modal-dd-btn').html();
		displayOnAddEditModal($(this).data('productid'), getSite, 'create');
	});

	$(document).on('click', '.spmc-open-list-btn', function (event) {
		event.stopPropagation();
		var getSite = ($('.search-product-modal-dd-btn').html() == 'Select Site') ? 'AKS' : $('.search-product-modal-dd-btn').html();
		setUrlParam('normalisedname', $(this).data('normalisednameni'));
		getByNormalisedName($(this).data('normalisednameni'), getSite);

		$('.dpbnm-product-nname').val($(this).data('normalisednameni'));
		$('.display-product-by-normalised-input').val(getSite)
		$('.displayProductByNormalisedName').modal('show');
	});


	// add edit modal section -----------------------------------------------------------
	$(document).on('click', '.ae-autocreation-checkbox', function () {
		var getMerchant = $(this).data('getmerchant')
		var getEdition = $(this).data('getedition')
		var getRegion = $(this).data('getregion')
		var getsite = $(this).data('getsite')
		var getUrl = $(this).data('aeurl')

		if ($(this).prop('checked')) {
			toCreateDataArr.push({
				'merchantID': "" + getMerchant + "",
				'url': getUrl,
				'region': "" + getRegion + "",
				'edition': "" + getEdition + "",
				'site': getsite
			});
		} else {
			var getIndex;
			toCreateDataArr.findIndex(function (item, i) {
				if (item.merchantID == getMerchant && item.edition == getEdition && item.region == getRegion && item.site == getsite) {
					getIndex = i;
					return true;
				}
			});
			toCreateDataArr.splice(getIndex, 1);
		}
	});

	$(document).on('change keyup', '.ae-url-input', function () {
		$('.ae-addc-i-on-aks-1, .ae-addc-i-on-aks-0-2, .ae-addc-i-on-cdd-1, .ae-addc-i-on-cdd-0-2, .ae-addc-i-on-brex-1, .ae-addc-i-on-brex-0-2').empty();
		toCreateDataArr = [];
		var getRegion = ($('.ae-region-input').val() == '') ? 2 : $('.ae-region-input').attr('data-regionid');
		getAvailable($('.ae-merchant-input').val(), getRegion);
	});

	$(document).on('change', '.ae-merchant-input', function () {
		$('.ae-addc-i-on-aks-1, .ae-addc-i-on-aks-0-2, .ae-addc-i-on-cdd-1, .ae-addc-i-on-cdd-0-2, .ae-addc-i-on-brex-1, .ae-addc-i-on-brex-0-2').empty();
		toCreateDataArr = [];
		var getRegion = ($('.ae-region-input').val() == '') ? 2 : $('.ae-region-input').attr('data-regionid');
		getAvailable($(this).val(), getRegion);
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
				$('.dmd-edition').prepend(getOuput[i].toAppend);
			} else {
				$('.dmd-edition').append(getOuput[i].toAppend);
			}
		}
	});

	$(document).on('click', '.dmds-edition', function () {
		$('.ae-addc-i-on-aks-1, .ae-addc-i-on-aks-0-2, .ae-addc-i-on-cdd-1, .ae-addc-i-on-cdd-0-2, .ae-addc-i-on-brex-1, .ae-addc-i-on-brex-0-2').empty();
		$('.ae-edition-input').val($(this).data('idni'));
		$('.dmd-edition').hide();
		toCreateDataArr = [];
		var getRegion = ($('.ae-region-input').val() == '') ? '2' : $('.ae-region-input').attr('data-regionid');

		getAvailable($('.ae-merchant-input').val(), getRegion);
	});

	$(document).on('click input', '.ae-region-input', function () {
		$('.dropdown-menu-div').hide();
		$('.dmd-region').show().empty();
		var getVal = $(this).val();
		var getOuput = saveRegion.filter(function (items) {
			return items.id.includes(getVal) || items.name.includes(getVal);
		});

		for (var i in getOuput) {
			$('.dmd-region').append(getOuput[i].toAppend);
		}
	});

	$(document).on('click', '.dmds-region', function () {
		$('.ae-addc-i-on-aks-1, .ae-addc-i-on-aks-0-2, .ae-addc-i-on-cdd-1, .ae-addc-i-on-cdd-0-2, .ae-addc-i-on-brex-1, .ae-addc-i-on-brex-0-2').empty();
		$('.ae-region-input').val($(this).data('nameni'));
		$('.ae-region-input').attr('data-regionid', $(this).data('idni'));
		$('.dmd-region').hide();
		toCreateDataArr = [];

		getAvailable($('.ae-merchant-input').val(), $(this).data('idni'));
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
		// console.log(toCreateDataArr.length);

		if (toCreateDataArr.length == 0) {
			alertMsg("Invalid data, kindly check it carefully", "bg-danger")
		} else {
			var serialize = $('#ae-mcb-row :input').serializeArray();
			var dataRequest = aeProduct(serialize, 'create');
			//console.log(dataRequest)
			AjaxCall(url, dataRequest).done(aeAddSuccess).always(function () {
				$(".add-edit-store-game-modal").modal('hide');
				setUrlParam('normalisedname', $(".ae-gameid-input").val());
				$('.dpbnm-product-nname').val($(".ae-gameid-input").val())
				$('.display-product-by-normalised-input').val($('.ae-product-p-title').html())
				$('.display-product-by-normalised-input').attr('data-product-website', $('.ae-product-p-title').html()) //used for delete
				$('.displayProductByNormalisedName').modal('show')
				getByNormalisedName($(".ae-gameid-input").val(), $('.ae-product-p-title').html());
				alertMsg("Successfully created", "bg-success")
			});
		}

	});

	$(document).on('click', '#ae-btn-edit', function () {
		var serialize = $('#ae-mcb-row :input').serializeArray();
		var dataRequest = aeProduct(serialize, 'edit');
		AjaxCall(url, dataRequest).done(function (data) {
			createNotification(data[0].id, data[0].merchant, 'Edited', data[0].site, data[0].user, data[0].normalised_name, data[0].buy_url);
		}).always(function () { });
	});

	//display by normalised name section ---------------------------------

	$(document).on('click', '.display-product-by-normalised-input', function () {
		$('.dropdown-menu-div').hide();
		$('.dmd-dpbn').show();
	});

	$(document).on('click', '.dmds-dpbn', function () {
		$('.display-product-by-normalised-input').val($(this).html());
		$('.display-product-by-normalised-input').attr('data-product-website', $(this).html());
		$('.dmd-dpbn').hide();
		getByNormalisedName($('.dpbnm-product-nname').val(), $(this).html());
	});

	$(document).on('input', '.dpbnm-product-nname', function () {
		var valid = /^\d+\.\d*$|^[\d]*$/;
		var number = /\d+\.\d*|[\d]*|[\d]+\.[\d]*|[\d]+/;
		if (!valid.test(this.value)) {
			var n = this.value.match(number);
			this.value = n ? n[0] : '';
		} else {
			setUrlParam('normalisedname', $(this).val());
			getByNormalisedName($(this).val(), $('.display-product-by-normalised-input').val());
		}
	});

	$(document).on('click', '.dpbnm-product-action', function () {
		$('.dpbnm-product-action-div').hide();

		if ($(this).attr('id') == toClose) {
			$('#dpbnmpad-div-' + $(this).attr('id')).hide();
			toClose = '';
		} else {
			$('#dpbnmpad-div-' + $(this).attr('id')).show();
			toClose = $(this).attr('id');
		}
	});

	// $(document).on('click', '.dpbnm-update-stock', function () {
	// 	// var setValue = ($(this).html() == 'Out Of Stock')? 'In Stock': 'Out Of Stock';
	// 	// var getSite = $('.display-product-by-normalised-input').val();
	// 	// alert($(this).data('dpbnm-id'))
	// 	// alert(setValue)
	// });

	$(document).on('click', '.dpbnm-li-toedit', function () {
		var getSite = $('.display-product-by-normalised-input').val();
		displayOnAddEditModal($(this).data('dpbnm-id-toedit'), getSite, 'edit');
	});

	//Product Stock Manual Update
	$(document).on('click', '.dpbnm-update-stock', function () {
		var $initialStock = parseInt($(this).attr('data-stockvalue'));
		var $this = $(this);
		const expected = [0, 1];
		if (expected.includes($initialStock)) {
			switch ($(this).attr('data-stock')) {
				case 'product-game-modal':
					productUpdateStock($(this).attr('data-dpbnm-id'), $initialStock, $('.display-product-by-normalised-input').attr('data-product-website'), $this);
					break;
				case 'product-store-page':
					//productUpdateStock($(this).attr('data-prodId'), $initialStock, $('.dropdown-menu-btn').text(), $this);
					break;
				default: alertMsg("Something Went wrong !!", "bg-danger");
					break;
			}
		} else {
			alertMsg("Please reload the page somethings broken", "bg-danger");
		}
	});

	//Product Price Manual Update
	$(document).on('keyup change', '.dpbnm-update-price', function (e) {
		var valid = /^\d+\.\d*$|^[\d]*$/;
		var number = /\d+\.\d*|[\d]*|[\d]+\.[\d]*|[\d]+/;

		if (!valid.test(this.value)) {
			var n = this.value.match(number);
			this.value = n ? n[0] : '';
		} else {
			if (e.which == 13) {
				var $this = $(this)
				this.value = addZeroesInPrice(this.value)
				switch ($(this).attr('data-price')) {
					case 'product-game-modal':
						productUpdatePrice($(this).attr('data-dpbnm-id'), this.value, $('.display-product-by-normalised-input').attr('data-product-website'), $this)
						break;
					case 'product-store-page':
						//productUpdatePrice($(this).attr('data-dpbnm-id'), this.value, $('.productNormalizedName').attr('data-product-website'), $this)
						break;
					default: alertMsg("Something Went wrong !!", "bg-danger");
						break;
				}
			}
		}
	})

	//Product Manual Delete
	$(document).on('click', '.dpbnm-delete-product', function () {
		var getId = $(this).closest("div").attr("id").split("-");
		var $this = $(this);
		if (getId.length === 3) {
			var request = {
				action: "ae-delete-action",
				productId: getId[2],
				gameId: $(".dpbnm-product-nname").val(),
				link: $(".row-" + getId[2] + " .dpbnm-product-url").attr("href"),
				merchant: $(".row-" + getId[2] + " .dpbnm-product-merchant").attr("data-product-merchant"),
				source: $('.display-product-by-normalised-input').attr("data-product-website"),
			}
			$modalContent = {
				header: '<div id="confimation-div-header-style">Are you sure?</div>',
				body: '<div id="confimation-div-body-style">Do you really want to delete this OFFER? </div>',
				footer: '<input id="confirmation-product-delete-btn" class="col-3 button-on" style="border-radius:5px;" type="button" value="Delete">'
			}
			confirmationDialog($modalContent, "confirmation-product-delete-btn", function (e) {
				AjaxCall(url, request).done(function (data) {
					createNotification(data[0].id, data[0].merchant, 'Deleted', data[0].site, data[0].user, data[0].normalised_name, data[0].buy_url);
					$this.closest('tr').prev().remove();//remove first the prev
					$this.closest('tr').remove();
				})
			})
		}
	});

}); // end docuemtn ready

function aeAddSuccess(data) {
	if (data.success != '') {
		$('.ae-addc-i-on-aks-1, .ae-addc-i-on-aks-0-2, .ae-addc-i-on-cdd-1, .ae-addc-i-on-cdd-0-2, .ae-addc-i-on-brex-1, .ae-addc-i-on-brex-0-2').empty();
		$('.ae-edition-input, .ae-region-input').val('');
		$('.ae-region-input').attr('data-regionid', '');
		$('.ae-edition-input').attr('data-editionid', '');
		toCreateDataArr = [];
		for (var i in data.success) { //Loop Per Website
			for (var j in data.success[i]) {
				createNotification(data.success[i][j].id, data.success[i][j].merchant, 'Created', data.success[i][j].site, data.success[i][j].user, data.success[i][j].normalised_name, data.success[i][j].buy_url);
			}
		}
	} else {
		alertMsg("Failed Message Here", "bg-danger")
	}
}

function createNotification($id, $merchantID, $what, $site, $employee, $normalisedName, $link) {
	var dataRequest = {
		action: 'insert-to-notifiction',
		getID: $id,
		gameID: $normalisedName,
		link: $link,
		getMerchantID: $merchantID,
		getWhat: $what,
		getSite: $site,
		getEmployee: $employee
	}
	AjaxCall(url, dataRequest).done(function () { }).always(function () { });
}

function addZeroesInPrice(num) {
	const dec = num.split('.')[1]
	const len = dec && dec.length > 2 ? dec.length : 2
	return Number(num).toFixed(len)
}

function aeProduct($form, $mode) {
	let formValues = {};
	let request = {};
	const editValues = ["ae-gameid-input", "ae-url-input", "ae-edition-input", "ae-region-input", "ae-ratings-input", "ae-merchant-input", "ae-buy-url-bis-input", "ae-url-raw-input", "ae-buy-url-tier-input", "ae-buy-url-4-input", "ae-search-name-input", "ae-category-input"];
	for (var i in $form) {
		if ($.inArray($form[i].name.toString(), editValues) != -1 && $mode == 'edit')
			formValues[$form[i].name] = $form[i].value
		else if ($mode == 'create')
			formValues[$form[i].name] = $form[i].value
	}
	switch ($mode) {
		case 'create':
			request = {
				action: 'ae-create-action',
				productformData: formValues,
				productOptions: toCreateDataArr,
				source: $('.ae-product-p-title').text(),
			}
			break;
		case 'edit':
			request = {
				action: 'ae-edit-action',
				productformData: formValues,
				productId: parseInt($('.ae-hidden-productid').val()),
				source: $('.ae-product-p-title').text(),
			}
			break;
		default:
			break;
	}
	return request;
}

function getMerchantsData() {
	let results = $.ajax({
		type: "GET", url: url + "app/getStores.json",
		async: false
	});
	return results.responseJSON;
}

function getByNormalisedName($normalisedName, $site) {
	$('.dpbnm-product-name').html('')
	$('.dpbnm-table-body').empty();
	$('.dpbnm-loader-wrapper').show();
	var dataRequest = {
		action: 'displayStoreGamesByNormalizedName',
		nnameID: $normalisedName,
		site: $site
	}
	AjaxCall(url, dataRequest).done(function (data) {
		$('.dpbnm-product-name').html('')
		var counter = 1;
		for (var i in data) {
			$('.dpbnm-product-name').html(data[0].searchName)
			displayProductBynormalised(data[i].merchantID, data[i].merchant, data[i].region, data[i].edition, data[i].status, data[i].price, data[i].buy_url, counter, data[i].id)
			counter++;
		}
	}).always(function (data) {

		$('.dpbnm-loader-wrapper').hide();
	});

}

function displayProductBynormalised($merchantID, $merchant, $region, $edition, $stock, $price, $url, $number, $id) {
	var backColor = ($number % 2 == 0) ? 'table-body-even-number-background' : '';
	var $stockValue = ($stock == 'In Stock') ? 1 : 0;
	var toAppend = '<tr class="row-' + $id + ' ' + backColor + '">';
	toAppend += '	<td class="ae-style-mre dpbnm-product-merchant" data-product-merchant="' + $merchantID + '" style="padding: 10px 10px;">' + $merchant + '</td>';
	toAppend += '	<td class="ae-style-mre" style="padding: 10px 10px;">' + $region + '</td>';
	toAppend += '	<td class="ae-style-mre" style="padding: 10px 10px;">' + $edition + '</td>';
	toAppend += '	<td class="hide-on-smmd data-stock" style="padding: 10px 10px;"><span class="dpbnm-update-stock" data-stock="product-game-modal" data-stockvalue="' + $stockValue + '" title="Click to update stock." alt="Click to update stock." data-dpbnm-id="' + $id + '">' + $stock + '</span></td>';
	toAppend += '	<td class="hide-on-smmd data-price" style="padding: 10px 10px;">';//' + $price + '
	toAppend += '<input type="text" data-dpbnm-id="' + $id + '" title="Press Enter to update the PRICE." class="dpbnm-update-price" value="' + $price + '" data-price="product-game-modal">';
	toAppend += '</td>';
	toAppend += '</tr>';
	toAppend += '<tr class="row-' + $id + ' ' + backColor + '">';
	toAppend += '	<td colspan="5">';
	toAppend += '		<div style="padding: 0 10px;word-break: break-all;position: relative;">';
	toAppend += '			<i class="fas fa-edit dpbnm-product-action" id="' + $id + '"></i>';
	toAppend += '			<div class="dpbnm-product-action-div" id="dpbnmpad-div-' + $id + '">';
	toAppend += '				<ul class="dpbnm-product-action-ul">';
	toAppend += '					<li class="dpbnm-product-action-li dpbnm-li-toedit" data-dpbnm-id-toedit="' + $id + '"><i class="fas fa-circle fa-xs"></i> <span class="dpbnm-product-action-li-span">Edit</span></li>';
	toAppend += '					<li class="dpbnm-product-action-li"><i class="fas fa-circle fa-xs"></i> <span class="dpbnm-delete-product dpbnm-product-action-li-span">Delete</span></li>';
	toAppend += '				</ul>';
	toAppend += '			</div>';
	toAppend += '			<p class="hide-on-lgxl show-on-smmd">Price : <input type="text" data-dpbnm-id="' + $id + '" title="Press Enter to update the PRICE." class="dpbnm-update-price" value="' + $price + '" data-price="product-game-modal"></p>';
	toAppend += '			<p class="hide-on-lgxl show-on-smmd"><button class="dpbnm-update-stock btn btn-primary col-12" data-stock="product-game-modal" data-stockvalue="' + $stockValue + '" data-dpbnm-id="' + $id + '">' + $stock + '</button></p>';
	toAppend += '			<p class="ae-style-url"><a class="dpbnm-product-url" href="' + html_decode($url) + '" target="_blank" style="color: #6b6d70;">' + html_decode($url) + '</a></p>';
	toAppend += '		</div>';
	toAppend += '	</td>';
	toAppend += '</tr>';

	$(".dpbnm-table-body").append(toAppend);
}

function unsetUrlParam($param) {
	var getUrl = window.location.href;
	var getMatch = getUrl.match(/(\?|\&)([^=]+)\=([^&]+)/gm);

	if (getMatch == '?' + $param + '=true') {
		var notCleanUrl = removeURLParameter(getUrl, $param);
		var getClean = notCleanUrl.substr(notCleanUrl.length - 1);
		if (getClean == '?') getClean = notCleanUrl.substring(0, notCleanUrl.length - 1);
		var newurl = getClean;
	} else var newurl = removeURLParameter(getUrl, $param);

	pushtoNewUrl(newurl);
}

function setUrlParam($param, $paramVal) {

	var getUrl = window.location.href;
	var getMatch = getUrl.match(/(\?|\&)([^=]+)\=([^&]+)/gm);
	var getParamVal = ($paramVal == '') ? 'true' : $paramVal;

	if (getMatch) {
		if (!getUrlParameter($param)) {
			var newurl = window.location.protocol + "//" + window.location.host + window.location.pathname + getMatch + "&" + $param + "=" + getParamVal + "";
		} else {
			if ($param == 'normalisedname') {
				var newurl = window.location.protocol + "//" + window.location.host + window.location.pathname + "?" + $param + "=" + getParamVal + "";
			} else {
				var newurl = window.location.protocol + "//" + window.location.host + window.location.pathname + getMatch[0] + "&" + $param + "=" + getParamVal + "";
			}
		}
	} else {
		var newurl = window.location.protocol + "//" + window.location.host + window.location.pathname + "?" + $param + "=" + getParamVal + "";
	}

	pushtoNewUrl(newurl);
}

function pushtoNewUrl($newUrl) {
	window.history.pushState({ path: $newUrl }, '', $newUrl);
}

function displayOnAddEditModal($productid, $site, $mode) {
	$('.ae-addc-i-on-aks-1, .ae-addc-i-on-aks-0-2, .ae-addc-i-on-cdd-1, .ae-addc-i-on-cdd-0-2, .ae-addc-i-on-brex-1, .ae-addc-i-on-brex-0-2').empty();
	callEdition();
	callRegion($site);
	toCreateDataArr = [];

	var dataRequest = {
		action: 'get-product-info',
		toGet: $productid,
		site: $site
	}

	AjaxCall(url, dataRequest).done(function (data) {
		$('.ae-product-p-title').html($site);
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

		if ($mode == 'create') {
			getAvailable(data[0].merchant, '2'); // default 2 for steam gloabl
			$('.ae-gameid-input').css({ "pointer-events": "none", "background-color": "#ededed" });
			$('.ae-price-input').val(data[0].price).css({ "pointer-events": "auto", "background-color": "#ffffff" });

			$('.input-text-raw').hide();
		} else if ($mode == 'edit') {
			$('.input-text-raw').show();
			//$('.ae-price-input').val(data[0].price).attr('readonly', 'readonly');
			$('.ae-price-input').val(data[0].price);
			$('.ae-price-input').css({ "pointer-events": "none", "background-color": "#ededed" });

			$('.ae-url-raw-input').val(data[0].buy_url_raw);
			$('.ae-edition-input').val(data[0].edition);
			$('.ae-region-input').val(data[0].region);
			$('.ae-hidden-productid').val(data[0].id);
		}
	}).always(function () {
		var getRealBtnName = ($mode == 'create') ? 'Create' : 'Update';
		var getRealBtnID = ($mode == 'create') ? 'add' : 'edit';

		$('.ae-to-what').html($mode);
		$('.ae-modal-footer').empty().append('<button class="btn btn-primary mt-1" id="ae-btn-' + getRealBtnID + '">' + getRealBtnName + '</button>');
		$('.add-edit-store-game-modal').modal('show');
	});
}

function getVisible() {
	var dataRequest = {
		action: 'get-visible'
	}
	AjaxCall(url, dataRequest).done(function (data) {
		getVisibleArr = data;
	}).always(function () { });
}

function getAllowedRegion() {
	var dataRequest = {
		action: 'get-allowed-region'
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
		return items.merchantID.includes("" + $merchantID + "");
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
	//1st Check if merchant is Visible
	//2nd if merchant is Visible then Check Input Region is also visible otherwise it will not be created.

	var getEditionVal = ($('.ae-edition-input').val() == '') ? '1' : $('.ae-edition-input').val();
	var getNormalizedName = $('.ae-gameid-input').val();

	for (var i in $getArr) {
		var replaceUnderScoreVal = i.replaceAll("_", ".");
		if ($getArr[i] == 1) {
			if ($.inArray(replaceUnderScoreVal, $getRegionArr) != -1) {
				if (merchantExc.indexOf($getMerchantID) != -1 && getOriginalSite(replaceUnderScoreVal) == "CDD") {
					createSwitchForAvailable(replaceUnderScoreVal, 0, $getRegion, $getMerchantID);
					continue;
				}

				var getCheckExistingData = checkExistingData(
					$getMerchantID,
					getEditionVal,
					$getRegion,
					getNormalizedName,
					getOriginalSite(replaceUnderScoreVal),
					updateCurrency(replaceUnderScoreVal, $getUrl),
					replaceUnderScoreVal
				);
			} else {
				createSwitchForAvailable(replaceUnderScoreVal, 2, $getRegion, $getMerchantID);
			}
		} else {
			createSwitchForAvailable(replaceUnderScoreVal, 0, $getRegion, $getMerchantID);
		}
	}
}

function checkExistingData($merchant, $edition, $region, $normalisedName, $site, $url, $unconvertedSite) {
	var dataRequest = {
		action: 'ae-check-existing-data',
		getMerchant: $merchant,
		getEdition: $edition,
		getRegion: $region,
		getNname: $normalisedName,
		getSite: $site
	}

	AjaxCall(url, dataRequest).done(function (data) {
		if (data == 0) {
			createSwitchForAvailable($unconvertedSite, 1, $region, $merchant, $edition, $url);
			toCreateDataArr.push({
				'merchantID': $merchant,
				'url': $url,
				'region': $region,
				'edition': $edition,
				'site': $site
			});
		} else {
			createSwitchForAvailable($unconvertedSite, 4, $region, $merchant, $edition, $url);
		}
	});
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

function createSwitchForAvailable($getVisible, $available, $region, $merchantID, $edition, $aeurl) {

	switch ($getVisible) {
		case 'allkeyshop.com':
			var whatBox = 'ae-addc-i-on-aks-1';
			var whatNotAvail = 'ae-addc-i-on-aks-0-2';
			var toAppend = createCheckbox($available, 'forAKS', $region, 'AKS', $merchantID, $edition, $aeurl);
			break;
		case 'reviewitusa':
			var whatBox = 'ae-addc-i-on-cdd-1';
			var whatNotAvail = 'ae-addc-i-on-cdd-0-2';
			var toAppend = createCheckbox($available, 'forCDD', $region, 'CDD', $merchantID, $edition, $aeurl);
			break;
		case 'allkeyshop.com.gbp':
			var whatBox = 'ae-addc-i-on-brex-1';
			var whatNotAvail = 'ae-addc-i-on-brex-0-2';
			var toAppend = createCheckbox($available, 'forBrex', $region, 'BREXIT', $merchantID, $edition, $aeurl);
			break;
	}

	if ($available == 1) $('.' + whatBox).append(toAppend);
	else $('.' + whatNotAvail).append(toAppend);
}

function createCheckbox($available, $checkboxName, $checkboxRegion, $whatSite, $merchantID, $edition, $aeurl) {
	// NOTE :
	// 	0 = Merchant is not visible for creation
	// 	1 = Merchant is visible and Region is Allowed
	// 	2 = Merchant is visible but region is not allowed

	var merchantName = (merchantsHolder[$merchantID] !== undefined) ? merchantsHolder[$merchantID]['name1'] : 'Name Not Found';
	switch ($available) {
		case 1:
			var toAppend = '<div class="form-check text-primary" data-getid="' + $merchantID + '">';
			toAppend += '	<input class="form-check-input ae-autocreation-checkbox" name="' + $checkboxName + '" type="checkbox" value="" id="' + $checkboxName + $checkboxRegion + '" data-getmerchant="' + $merchantID + '" data-getedition="' + $edition + '" data-getregion="' + $checkboxRegion + '" data-getsite="' + $whatSite + '" data-aeurl="' + $aeurl + '" checked>';
			toAppend += '	<label class="form-check-label" for="' + $checkboxName + $checkboxRegion + '">';
			toAppend += '		Creating merchant <b>' + merchantName + ' ' + $merchantID + '</b> on <b class="text-primary">' + $whatSite + '</b> with edition <b>' + $edition + '</b> and region is <b>' + $checkboxRegion + '</b>';
			toAppend += '	</label>';
			toAppend += '</div>';
			break;
		case 2:
			var toAppend = '<i class="fas fa-circle" style="font-size: 10px;"></i> <span class="text-danger">Region <b>' + $checkboxRegion + '</b> is not allowed on <b>' + $whatSite + '</b></span><br>';
			break;
		case 3:
			break;
		case 4:
			var toAppend = '<i class="fas fa-circle" style="font-size: 10px;"></i> <span class="text-danger">Merchant <b>' + merchantName + ' ' + $merchantID + '</b> with edition <b>' + $edition + '</b> and region <b>' + $checkboxRegion + '</b> is already on <b>' + $whatSite + '</b></span><br>';
			break;
		default:
			var toAppend = '<i class="fas fa-circle" style="font-size: 10px;"></i> <span class="text-danger">Merchant <b>' + merchantName + ' ' + $merchantID + '</b> is not allowed on <b>' + $whatSite + '</b></span><br>';
			break
	}
	return toAppend;
}

function callEdition() {
	saveEdition = []
	var dataRequest = {
		action: 'get-edition'
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
			var append = '<div class="spmc-display-content-wrapper" data-merchantni=' + data[i].merchant + ' data-productid=' + data[i].id + ' data-productnormalisename=' + data[i].normalised_name + '>';
			append += '<div class="spmc-dcw-btn-div"><button class="btn btn-info spmc-open-list-btn" data-normalisednameni=' + data[i].normalised_name + '>Open list</button></div>';
			append += '<div class="spmc-dcw-merchant-div">' + data[i].vols_nom + '</div>';
			append += '<div class="spmc-dcw-url-div">' + html_decode(data[i].buy_url) + '</div>';
			append += '</div>';

			if ($.inArray(data[i].vols_nom, checkUnique) == -1) {
				checkUnique.push(data[i].vols_nom);
				$('.spmc-dm').append('<span class="dropdown-item spmc-dm-di" data-merchantni=' + data[i].merchant + ' data-productid=' + data[i].id + ' data-productnormalisename=' + data[i].normalised_name + '>' + data[i].vols_nom + '</span>')
			}
			$('.spm-content-display').append(append);
		}
	}).always(function (data) {

		$('.spm-content-body').show();
		$('.spmc-span-site').html($site)

		if (data.length == 0) {
			$('.spmc-display-header-span-what').html("No product found in ");
			$('.spmc-btn').hide();
			$('.spmc-request-id-btn').show();
		} else {
			// if (data.length > 1 && data.length < 4) $('.spm-dialog').removeClass('spm-dialog-height spm-dialog-height-min spm-dialog-height-mid spm-dialog-height-max').addClass('spm-dialog-height-min');
			// if (data.length > 4 && data.length < 7) $('.spm-dialog').removeClass('spm-dialog-height spm-dialog-height-min spm-dialog-height-mid spm-dialog-height-max').addClass('spm-dialog-height-mid');
			// if (data.length >= 7) $('.spm-dialog').removeClass('spm-dialog-height spm-dialog-height-min spm-dialog-height-mid spm-dialog-height-max').addClass('spm-dialog-height-max');
			$('.spm-dialog').removeClass('spm-dialog-height spm-dialog-height-min spm-dialog-height-mid spm-dialog-height-max').addClass('spm-dialog-height-max')
			// console.log(data.length)
			$('.spmc-display-header-span-what').html("Product found in ");
			$('.spmc-btn').hide();
			$('.spmc-btn-merchant-create').show();
		}
		$('.spmc-loader-wrapper').hide();
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
function AjaxCall($url, $data, $loader) {
	// NOTE: 
	// 	done = success
	// 	always = complete

	return $.ajax({
		url: $url,
		type: "POST",
		data: $data,
		beforeSend:function(jqXHR){
			$loader;
		}
	})
}

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
				default:
					break;
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
				case 'localStorage':
					$item = localStorage.getItem($key);
					break;
				case 'sessionStorage':
					$item = sessionStorage.getItem($key);
					break;
				default:
					break;
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
				case 'localStorage':
					localStorage.removeItem($key);
					break;
				case 'sessionStorage':
					sessionStorage.removeItem($key);
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

function alertMsg($msg, $bgColor) {
	// NOTE :
	// 	bg-daner is for error
	// 	bg-success if or success

	$('#alert-modal').modal('show');
	$('.alert-modal-bg').removeClass('bg-danger bg-success').addClass($bgColor);
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

function storeUpdateProduct($productID, $toWhat, $dataTo, $site) {
	var dataRequest = {
		action: 'storeUpdateProduct',
		id: $productID,
		toWhat: $toWhat,
		dataTo: $dataTo,
		site: $site
	};
	switch ($toWhat) {
		case 'price':
			var $checkedPrice = $dataTo.match(/(\d+\.[\d+]{1,2}|\d+)/);
			var $checkedWords = $dataTo.match(/([^.\d])/);
			if ($checkedWords)
				flag = true; //theres an error
			else {
				if ($checkedPrice) {
					flag = false;
					dataRequest.dataTo = $checkedPrice[1]
				}
				else
					flag = true; //theres an error
			}
			(flag) ? true : dataRequest;
			break;
		case 'stock':
			dataRequest;
			break;
	}

}
function productUpdateStock($productID, $stock, $site, $this) {
	var req = {
		action: 'productUpdateStock',
		id: $productID,
		stock: $stock,
		gameId: $(".dpbnm-product-nname").val(),
		link: $(".row-" + $productID + " .dpbnm-product-url").attr("href"),
		merchant: $(".row-" + $productID + " .dpbnm-product-merchant").attr("data-product-merchant"),
		site: $site
	}
	AjaxCall(url, req).done(function (data) {
		if (data.bool) {
			var data = data.data;
			createNotification(data[0].id, data[0].merchant, 'Stock Update', data[0].site, data[0].user, data[0].normalised_name, data[0].buy_url);
			switch ($stock) {
				case 0:
					//($this.attr("type") == "button") ? $($this).val('In Stock') : $($this).html('In Stock');
					//$($this).attr('data-stockvalue', 0);
					($this.attr("type") == "button") ? $(".row-" + $productID + " .dpbnm-update-stock").val('In Stock') : $(".row-" + $productID + " .dpbnm-update-stock").html('In Stock');
					$(".row-" + $productID + " .dpbnm-update-stock").attr('data-stockvalue', 1);
					alertMsg("Successfully update to In Stock", "bg-success");
					break;
				case 1:
					//($this.attr("type") == "button") ? $($this).val('Out Of Stock') : $($this).html('Out Of Stock');
					//$($this).attr('data-stockvalue', 0);
					($this.attr("type") == "button") ? $(".row-" + $productID + " .dpbnm-update-stock").val('Out Of Stock') : $(".row-" + $productID + " .dpbnm-update-stock").html('Out Of Stock');
					$(".row-" + $productID + " .dpbnm-update-stock").attr('data-stockvalue', 0);
					alertMsg("Successfully update to Out of Stock", "bg-success");
					break;
			}
		} else {
			alertMsg("Stock value didnt Update", "bg-danger");
		}
	});
}
function productUpdatePrice($productID, $price, $site, $this) {
	var req = {
		action: 'productUpdatePrice',
		id: $productID,
		price: $price,
		gameId: $(".dpbnm-product-nname").val(),
		link: $(".row-" + $productID + " .dpbnm-product-url").attr("href"),
		merchant: $(".row-" + $productID + " .dpbnm-product-merchant").attr("data-product-merchant"),
		site: $site
	}
	AjaxCall(url, req).done(function (data) {
		if (data.bool) {
			var data = data.data;
			createNotification(data[0].id, data[0].merchant, 'Price Update', data[0].site, data[0].user, data[0].normalised_name, data[0].buy_url);
			//$($this).val($price);
			$(".row-" + $productID + " .dpbnm-update-price").val($price);
			alertMsg("Successfully update the price to " + $price + "", "bg-success");
		}
	});
}

function confirmationDialog($display, confirmationBtnId, onConfirm) {
	var fClose = function () {
		modal.modal("hide");
	};
	var modal = $("#report-modal-confirmation");
	modal.modal('show');
	$('#confirmation-header-tittle').empty().html($display.header);
	$('#confirmation-body-div').empty().append($display.body);
	$('#confirmation-footer-div').empty().append($display.footer);
	$("#" + confirmationBtnId).unbind().one('click', onConfirm).one('click', fClose);
}