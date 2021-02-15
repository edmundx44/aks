var toggleVal = 0;
var sidebarDisplay = (localStorage.getItem("sidebar-active") == "sidebar-yes")? sidebarDiv() : '';
var clickState = 0;
$(document).ready(function(){
	displayIcon();
	// var pathname = window.location.pathname;     
	// var origin   = window.location.origin;
	// var url      = window.location.href; 
	// localStorage.clear();
	$(window).resize(function() {
		if ($(window).width() > 768) {
			$('.sidebar').removeClass('sidebar-reponsive');
			$('.bg-div').hide();
		}
	});


	$(document).on('click', '.sidebar-menu-btn', function(){
		$('.sidebar').toggleClass('sidebar-reponsive');
		$('.bg-div').toggle();
	});

	$(document).on('click', '.dropdown-li', function(){
		$('.'+$(this).attr('id')).toggle().removeClass('show-div');
	});

	$(document).on('click', '.sidebar-minimize', function(){
		localStorage.setItem("sidebar-active", (localStorage.getItem("sidebar-active") == "sidebar-yes")? "sidebar-no":"sidebar-yes" );
		sidebarDiv()
	});
	
	$(document).on('click', '.sidebar-footer-img', function(){
		$('.div-img-logout-settings').toggle("fast");
	});

	$(document).on('click', function(event){    
	    if(!$(event.target).is('.sidebar-footer-img, .div-img-logout-settings')) {
	        $('.div-img-logout-settings').hide("fast");
	    }
	});
	
	
	// $(document).on('click', '.navbar-expand-md', function(){
	// 	alert(localStorage.getItem("sidebar-active"))
	// });
	
}); // end docuemtn ready


// custom function here -------------------------------------------------------------------------
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

function sidebarDiv() {

		var cssvar = '.sidebar-menu-value, .li-nav-dd, .sidebar-footer-welcome, .sidebar-footer-name, .sidebar-footer-logout-icon';
		if (toggleVal == 0) { 
			$(cssvar).hide(); 
			$('.sidebar-logo-img-1').hide();
			$('.sidebar-logo-img-2').fadeIn();
			$('.sidebar-minimize-icon').removeClass('fa-angle-double-left').addClass('fa-angle-double-right');
			$('.sidebar-minimize').css({'background': 'linear-gradient(60deg, #ab47bc, #8e24aa)', 'color':'#fff'});
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
}

