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

var crProblemArr = [];

	$div.css({
		left: Math.floor( Math.random() * widthMax ),
		top: Math.floor( Math.random() * heightMax )
	});
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
	displayIcon();
	displayMode(localStorage.getItem("body-mode"));
	//console.log(removeSiteInLocalStorage(uri));

	$('.modal-dialog').draggable({
		handle: ".modal-content",
		cancel: 'span, input'
	});

	// var pathname = window.location.pathname;     
	// var origin   = window.location.origin;
	// var url      = window.location.href; 
	// localStorage.clear();

	$(document).keydown(function(event){
		

		if((event.which === 65 && event.altKey)) {
			$('.modal').modal('hide');
			$('.add-edit-store-game-modal').modal('show');
		}
		if((event.which === 82 && event.altKey)) {
			$('.modal').modal('hide');
			crProblemArr = [];
			$('#createReportModal').modal('show');
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

	$(document).on('click', '.switch-checkbox',function(){
		if($(this).is(":checked")){
			if(scroll >= 220) $('.header-content-stickey').css({'background': 'rgba(39, 41, 61, 1)'});
			displayMode('darkmode');
		}else{
			if(scroll >= 220) $('.header-content-stickey').css({'background': 'rgba(255, 255, 255, 1)'});
			displayMode('normal');
		}
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
		$('.'+$(this).attr('id')).toggle().removeClass('show-div');
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

// dashboard function here -----------------------------------
function displayIcon(){
	var iconList = [
		"fa-pie-chart",
		"fa-bar-chart",
		"fa-google-wallet",
		"fa-briefcase",
		"fa-line-chart",
		"fa-ravelry",
		"fa-modx"
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

// ajax call function ---------------------------------------
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
		$('.sidebar-logo-img-2').fadeIn();
		$('.sidebar-minimize-icon').removeClass('fa-angle-double-left').addClass('fa-angle-double-right');
		$('.sidebar-minimize').css({'background': 'linear-gradient(60deg, #004ea3, #0062cc)', 'color':'#fff'});
		toggleVal = 1;
	} else { 
		$(cssvar).fadeIn(600); 
		$('.sidebar-logo-img-2').hide();
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

function debounce(fun, mil){
    var timer; 
    return function(){
        clearTimeout(timer); 
        timer = setTimeout(function(){
            fun(); 
        }, mil); 
    };
}

function OptionSite(inputs,className,classParent,bgColor){
	var	opt = 		'<div class="select '+bgColor+'">';
		opt += 			'<span class="selected-data change-site">Website</span>';
		opt += 			'<span class="pull-right"><i class="fa fa-caret-down" aria-hidden="true"></i></span>';
		opt += 		'</div>';
		opt += 		'<ul class="dropdown-menu cos-dropdown-menu '+classParent+'">'
		opt += 			'<li class='+className+' data-website='+inputs[0].site+'>AKS</li>';
		opt += 			'<li class='+className+' data-website='+inputs[1].site+'>CDD</li>';
		opt += 			'<li class='+className+' data-website='+inputs[2].site+'>BREXITGBP</li>';
		opt += 		'</ul>';
	return opt
}
function returnSite($site){
	switch($site){
		case 'aks' : $site;
		break;
		case 'cdd' : $site;
		break;
		case 'brexitgbp' : $site;
		break;
		default: $site = 'invalid';
		break
	}
	return $site;
}

function localStorageCheck(){
	return (typeof(Storage) !== "undefined") ? true : false;
}
function sessionStorageCheck(){
	return (typeof(Storage) !== "undefined") ? true : false;
}
function setStorage($type,$key,$value){
	switch($type){
		case 'localStorage':
			localStorage.setItem($key,$value);
		break;
		case 'sessionStorage':
			sessionStorage.setItem($key,$value);
		break;
		default:
		break;
	}
}
function getStorage($type,$key){
	switch($type){
		case 'localStorage':
			var items = localStorage.getItem($key);
		break;
		case 'sessionStorage':
			var items = sessionStorage.getItem($key);
		break;
		default:
			return 'invalid';
		break;
	}
	return items;
}

function removeExistingItem($type,$key,$path){
	//$path is path of the utilities page u can use uri variable
	//use this to remove existing key 
	// if (!removeExistingItem('sessionStorage','OptionSite',uri)){
	// 		console.log('Item has been removed');
	// 	}
	switch($type){
		case 'localStorage':
			var object = JSON.parse(localStorage.getItem($key));	
			if (object === null)  return true;
			else if($path == object.path) return true;
		    else if($path != object.path){
		    	localStorage.removeItem($key);
		    	return false;
		    }
		break;
		case 'sessionStorage':
			var object = JSON.parse(sessionStorage.getItem($key));	
			if (object === null)  return true;
			else if($path == object.path) return true;
		    else if($path != object.path){
		    	sessionStorage.removeItem($key);
		    	return false;
		    }
		break;
		default:
			return true;
		break;
	}
}

function removedKeyNormal($type,$key){
	switch($type){
		case 'localStorage':
			localStorage.removeItem($key);
		break;
		case 'sessionStorage':
			sessionStorage.removeItem($key);
		break;
		default:
			return false;
		break;
	}
	return true;
}
function confirmationModal($appendtoheader, $appendtobody, $appendtofooter){
	$('#report-modal-confirmation').modal('show');
	$('.confirmation-tittle').empty().html($appendtoheader);
	$('.modal-content-body').empty().append($appendtobody)
	$('.confirmation-modal-footer').empty().append($appendtofooter)
}
