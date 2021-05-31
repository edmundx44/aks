var toggleVal = 0,
	sidebarDisplay = (localStorage.getItem("sidebar-active") == "sidebar-yes")? sidebarDiv() : '',
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
	var month = d.getMonth()+1;
	var day = d.getDate();

	var crProblemArr = [];

	$div.css({
		left: Math.floor( Math.random() * widthMax ),
		top: Math.floor( Math.random() * heightMax )
	});

	
	var queryString = window.location.search;
	var uri = window.location.pathname;
	//ESCAPE SPECIAL CHARACTERS
	var entityMap = {
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

$(document).ready(function(){
	removeEmptyTitle();
	displayIcon();
	displayMode(localStorage.getItem("body-mode"));

	$('.modal-dialog').draggable({
		handle: ".modal-content",
		cancel: 'span, input, .nfof-feedback, .pc-asb-modal*, .modal-content-body*'
	});

	// var pathname = window.location.pathname;     
	// var origin   = window.location.origin;
	// var url      = window.location.href; 
	// localStorage.clear();

	$(document).on('click', '.dropdown-website', function(){ $(this).find('.website-menu').slideToggle(200); });
	
	$(document).keydown(function(event){
		
		if(event.which === 27) {
			$('.modal').modal('hide');
		}
		if((event.which === 65 && event.altKey && event.shiftKey)) {
			$('.modal').modal('hide');
			$('.add-edit-store-game-modal').modal('show');
		}
		if((event.which === 82 && event.altKey && event.shiftKey)) {
			$('.modal').modal('hide');
			crProblemArr = [];
			$('#createReportModal').modal('show');
		} 
		if((event.which === 68 && event.altKey && event.shiftKey)) {
			$('.switch-checkbox').trigger('click');
		} 
		
		if((event.which === 81 && event.altKey && event.shiftKey)) {
			window.location.href = "/aks/dashboard/activities";
		} 
		
	}); 

	$(window).scroll(function(){
		scroll = $(window).scrollTop();
		scrollThis();
	});

	$(window).resize(function() {
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

	$(document).on('click', '.li-darknormal-switch, .span-switch-name',function(e){
		if(e.target == e.currentTarget) {
			$('.switch-checkbox').trigger('click')
		}
	});

	$(document).on('click', '.switch-checkbox',function(){
		if($(this).is(":checked")){
			if(scroll >= 220) $('.header-content-stickey').css({'background': 'rgba(39, 41, 61, 1)'});
			displayMode('darkmode');
		}else{
			if(scroll >= 220) $('.header-content-stickey').css({'background': 'rgba(255, 255, 255, 1)'});
			displayMode('normal');
		}
    });

	$(document).on('click', '.logout-function-on-li',function(){
		window.location.href = $(this).data('urlni');
	});
    


	$(document).on('click', '.float-settings-menu', function(){
		$('.modal').modal('hide');
		switch($(this).attr('id')){
			case 'btn-create-report':
				crProblemArr = [];
				$('#createReportModal').modal('show');
			break;
			case 'btn-add-edit':
				$('.add-edit-store-game-modal').modal('show');
			break;

		}
		
	});

	$(document).on('click', '.settings-icon', function(){
		$(".float-settings-menu").each(function(index){
			$(this).toggleClass('menu-'+index)
	    });
		$(".float-settings-icon").toggleClass('show-div');
		
	});
	$(document).on('click', '.sidebar-menu-btn', function(){
		$('.sidebar').toggleClass('sidebar-reponsive');
		$('.bg-div').toggle();
		pageSwitch = (pageSwitch == 0)? 1 : 0;
	});

	$(document).on('click', '.dropdown-li', function(){
		$('.'+$(this).attr('id')).slideToggle('fast').removeClass('show-div');
	});

	$(document).on('click', '.sidebar-minimize', function(){
		localStorage.setItem("sidebar-active", (localStorage.getItem("sidebar-active") == "sidebar-yes")? "sidebar-no":"sidebar-yes" );
		sidebarDiv();
	});
	
	$(document).on('click', '.sidebar-footer-img', function(){
		$('.div-img-logout-settings').toggle("fast");
	});

	$(document).on('click', function(event){    
		if(!$(event.target).is('.sidebar-footer-img, .div-img-logout-settings *')) {
			$('.div-img-logout-settings').hide("fast");
		}
		if(!$(event.target).is('.settings-icon, .float-settings-menu, .float-settings-icon')) {
			$(".float-settings-menu").each(function(index){
				$(this).removeClass('menu-'+index)
			});
			$(".float-settings-icon").removeClass('show-div');
		}
	});
	
}); // end docuemtn ready


function removeEmptyTitle(){
	var items = $('body').find('.header-title');
	$.each(items, function (i, v) {
		if ($(items[i]).html().trim() === "") {
			$(items[i]).remove();
		}
	});
}

// dashboard function here -----------------------------------
function displayIcon(){
	var iconList = [
		"fa-chart-pie",
		// "fa-clipboard",
		"fa-link",
		"fa-podcast",
		"fa-store-alt",
		"fa-tools",
		"fa-power-off"
	];

	$('i#nav-icon').each(function(i){
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
		data : $data
	})
}
//$getInput = $getInput->get(); //use this get all data sent 
//$var = $getInput['site'];  //var sent {'site':$aks} 
function _ajaxCall($url,$type,$action,$data){
	return $.ajax({
		url:$url,
		type:$type,
		data:{
			action:$action,
			data: $data
		}
	})
}
function _ajaxCall_01($url,$type,$data){
	return $.ajax({
		url:$url,
		type:$type,
		data : $data
	})
}

// custom function here -------------------------------------
function scrollThis(){
	switch(localStorage.getItem("sidebar-active")) {
		case 'sidebar-yes':
			if (scroll >= 220) {
				if(localStorage.getItem("body-mode") == 'darkmode'){
					$('.header-content-stickey').css({'background': 'rgba(39, 41, 61, 1)'});
				}else{
					$('.header-content-stickey').css({'background': 'rgba(255, 255, 255, 1)'});
				}

				$('.header-content').addClass('header-content-stickey minimized-sb-sticky-header');
				$('.breadcrumbs-ul').addClass('breadcrumbs-ul-fixed '+$('.dropdown-menu-btn').text()+'-sticky-BGC breadcrumbs-ul-stickey minimized-sb-sticky');
				$('.store-page-search.form-control').addClass('minimized-sb-sticky');
				$('.breadcrumbs-arrow').addClass('breadcrumbs-arrow-rezise breadcrumbs-ul-stickey');
				$('.sticky-dropdown').show();
				$('.store-page-search').addClass('store-page-search-sticky');
				$('.store-search-btn').addClass('store-search-btn-sticky');	

				if($(window).width() <= 768){
					$('.header-content').removeClass('minimized-sb-sticky-header');
					$('.breadcrumbs-ul').removeClass('minimized-sb-sticky');
					$('.store-page-search.form-control').removeClass('minimized-sb-sticky');
				}
			}else {
				$('.header-content-stickey').css({'background': 'transparent'});
				$('.header-content').removeClass('header-content-stickey minimized-sb-sticky-header');
				$('.breadcrumbs-ul').removeClass('breadcrumbs-ul-fixed breadcrumbs-ul-stickey minimized-sb-sticky '+$('.dropdown-menu-btn').text()+'-sticky-BGC AKS-sticky-BGC CDD-sticky-BGC BREX-sticky-BGC');
				$('.breadcrumbs-arrow').removeClass('breadcrumbs-arrow-rezise breadcrumbs-ul-stickey');
				$('.sticky-dropdown').hide();
				$('.store-page-search').removeClass('store-page-search-sticky');
				$('.store-search-btn').removeClass('store-search-btn-sticky');
			}
		break;
		case 'sidebar-no':
			if (scroll >= 220) {
				if(localStorage.getItem("body-mode") == 'darkmode'){
					$('.header-content-stickey').css({'background': 'rgba(39, 41, 61, 1)'});
				}else{
					$('.header-content-stickey').css({'background': 'rgba(255, 255, 255, 1)'});
				}

				$('.header-content').addClass('header-content-stickey');
				$('.breadcrumbs-ul').addClass('breadcrumbs-ul-fixed '+$('.dropdown-menu-btn').text()+'-sticky-BGC breadcrumbs-ul-stickey');
				$('.breadcrumbs-arrow').addClass('breadcrumbs-arrow-rezise breadcrumbs-ul-stickey');
				$('.sticky-dropdown').show();
				$('.store-page-search').addClass('store-page-search-sticky');
				$('.store-search-btn').addClass('store-search-btn-sticky');		
			}else {
				$('.header-content-stickey').css({'background': 'transparent'});
				$('.header-content').removeClass('header-content-stickey minimized-sb-sticky-header');
				$('.breadcrumbs-ul').removeClass('breadcrumbs-ul-fixed '+$('.dropdown-menu-btn').text()+'-sticky-BGC AKS-sticky-BGC CDD-sticky-BGC BREX-sticky-BGC breadcrumbs-ul-stickey');
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
		$('.sidebar-minimize').css({'background': 'linear-gradient(60deg, #004ea3, #0062cc)', 'color':'#fff'});
		toggleVal = 1;
	} else { 
		$(cssvar).fadeIn(600); 
		$('.sidebar-logo-img-2, .li-nav-dd-mini').hide();
		$('.sidebar-logo-img-1').fadeIn(1000);
		$('.sidebar-minimize-icon').removeClass('fa-angle-double-right').addClass('fa-angle-double-left');
		$('.sidebar-minimize').css({'background':'#fff', 'color':'#6b6d70'});
		
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

	if(pageSwitch == 0) {
		switch(localStorage.getItem("sidebar-active")) {
			case 'sidebar-yes':
				if (scroll >= 220) {
					$('.header-content').addClass('header-content-stickey minimized-sb-sticky-header');
					$('.breadcrumbs-ul').addClass('breadcrumbs-ul-fixed '+$('.dropdown-menu-btn').text()+'-sticky-BGC breadcrumbs-ul-stickey minimized-sb-sticky');
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

function displayMode($mode){
	switch($mode){
		case 'darkmode':
			$('.header-content-stickey').css({'background': 'rgba(39, 41, 61, 1)'});
			$(".main-word").attr("src",url+"vendors/image/logo-word-darkmode.png");
			$(".main-logo").attr("src",url+"vendors/image/logo-black-darkmode.png");

			$(".li-nav-div, .sub-li-nav-div").removeClass('li-nav-and-sub-normal').addClass("li-nav-and-sub-darkmode");
			$('.sub-li-nav-div:hover').css({'background': '#1f2030'});
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
			$(".switch-checkbox").prop( "checked", true );

		break;
		case 'normal':
			$(".main-word").attr("src",url+"vendors/image/logo-word.png");
			$(".main-logo").attr("src",url+"vendors/image/logo-black.png");

			$(".li-nav-div, .sub-li-nav-div").removeClass('li-nav-and-sub-darkmode').addClass("li-nav-and-sub-normal");
			$('.header-content-stickey').css({'background': 'rgba(255, 255, 255, 1)'});
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
			$(".switch-checkbox").prop( "checked", false );
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

function debounce(fun, mil){
    var timer; 
    return function(){
        clearTimeout(timer); 
        timer = setTimeout(function(){
            fun(); 
        }, mil); 
    };
}

function safelyParseJSON (json) {
	var parsed = null;
	try {
		parsed = JSON.parse(json)
	} catch (e) {
		// do stuff here
	}
	return parsed;
}
function returnSite($site = null){
	try {
		switch($site){
			case 'aks' : $site;
			break;
			case 'cdd' : $site;
			break;
			case 'brexitgbp' : $site;
			break;
			default: $site = null;
			break
		}
	} catch (error) { }
	return $site;
}
function setStorage($type,$key,$value){
	var $return = true;
	try {
		if(typeof(Storage) !== "undefined") {
			switch($type){
				case 'localStorage': localStorage.setItem($key,$value);
				break;
				case 'sessionStorage': sessionStorage.setItem($key,$value);
				break;
				default: break;
			}
		}
	} catch (e) {
		$return = false
	}
	return $return;
}
function getStorage($type,$key){
	var $item = null;
	try {
		if((typeof(Storage) !== "undefined")){
			switch($type){
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

function removeExistingItem($type,$key,$path){
	//$path is path of the utilities page u can use uri variable
	//use this to remove existing key 
	// if (!removeExistingItem('sessionStorage','OptionSite',uri)){
	// 		console.log('Item has been removed');
	// 	}
	switch($type){
		case 'localStorage':
			var object = safelyParseJSON(localStorage.getItem($key));	
			if (object === null)  return true;
			else if($path == object.path) return true;
		    else if($path != object.path){
		    	localStorage.removeItem($key);
		    	return false;
		    }
		break;
		case 'sessionStorage':
			var object = safelyParseJSON(sessionStorage.getItem($key));	
			if (object === null)  return true;
			else if($path == object.path) return true;
		    else if($path != object.path){
		    	sessionStorage.removeItem($key);
		    	return false;
		    }
		break;
		default: return true;
		break;
	}
}

function removedKeyNormal($type,$key){
	var $bool = true;
	try {
		if(typeof(Storage) !== "undefined"){
			switch($type){
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

function confirmationModal($appendtoheader, $appendtobody, $appendtofooter){
	$('#report-modal-confirmation').modal('show');
	$('.confirmation-tittle').empty().html($appendtoheader);
	$('.modal-content-body').empty().append($appendtobody)
	$('.confirmation-modal-footer').empty().append($appendtofooter)
}

function alertMsg($msg){
	$('#alert-modal').modal('show');
	$('.alert-modal-msg').empty().append($msg);
	setTimeout( function(){ 
		$('#alert-modal').modal('hide');
	}, 2000 );
}
 
function returnSiteClass($site){
	switch($site){
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
function eRegex($string){
	switch ($string){
		case '+': case '-': case '*':  case '/':  case '?':  case '^':  case '|': 
			$string = "\/" + $string;
		break;
		default:
		break;
	}
	return $string;
}

function displayStoreGamesByNormalizedName($normalised_name,$site) {
	var dataRequest =  {
		action: 'displayStoreGamesByNormalizedName',
		nnameID: $normalised_name,
		site: $site
	}

	AjaxCall(url, dataRequest).done(function(data) {
		$('.productName').text(data[0].searchName);
		$('.productNormalizedName').text(data[0].nname);
		$('#displayStoreGamesByNormalizedName').modal('show');
		$('.nname-modal-tbody').empty();
		//console.log(data);
		for(var i in data) {
			var append = 	'<div class="nname-modal-tbody-div '+data[i].id+'">';
				append +=	'<div class="modal-child-tbody-1">'+data[i].merchant+'</div>';
				append +=	'<div class="modal-child-tbody-2">'+data[i].region+'</div>';
				append +=	'<div class="modal-child-tbody-3">'+data[i].edition+'</div>';
				append +=	'<div class="modal-child-tbody-sub modal-child-tbody-4"><input class="modal-val-btn" type="button" 	data-prodId="'+data[i].id+'" 	value="'+data[i].status+'"></div>';
				append +=	'<div class="modal-child-tbody-sub modal-child-tbody-5"><input id="price-update" class="modal-val-txt" type="number" 	data-prodId="'+data[i].id+'"	value="'+data[i].price+'"></div>';
				append +=	'<div class="modal-child-tbody-sub modal-child-tbody-6">';
				append += 	'<div class="show-menu" id="'+data[i].id+'">';
				append += 	'<ul class="modal-setting-ul">';
				append += 	'<li class="modal-setting-ul-li"><i class="fa fa-pencil" aria-hidden="true"></i><span class="msulspan add-edit-from-display" data-toeditid="'+data[i].id+'">Edit</span></li>';
				append += 	'<li class="modal-setting-ul-li"><i class="fa fa-times" aria-hidden="true"></i><span class="msulspan">Delete</span></li>';
				append += 	'<li class="modal-setting-ul-li"><i class="fa fa-dot-circle-o" aria-hidden="true"></i><span class="msulspan">Others</span></li>';
				append += 	'</ul>';
				append +=	'</div>';
				append += 	'<button class="btn action-btn '+data[i].site+'-btn" id="'+data[i].id+'"> <i class="fa fa-cogs btn-icon-acb" aria-hidden="true"></i></button>';
				append +=   '</div>';
				append +=	'<div><p class="nname-modal-tfoot"><a href="'+data[i].buy_url+'" target="_blank">'+html_decode(data[i].buy_url)+'</a></p></div>';
				append +=	'</div>';
			$(".nname-modal-tbody").append(append);
		}
	});
}
