<?php
	$origin = $_SERVER['REQUEST_SCHEME'] . '://' . $_SERVER['HTTP_HOST'];

	if ($origin == 'http://localhost'){
		$pathname = '/aks/';
		$dbPassword = '';
	}else{
		$pathname = '/admin/bot_de_v2/aks/';
		$dbPassword = 'jcBf9aA6w7WbLy5x';
	}

	define('DB_HOST', '127.0.0.1'); // database host
	// define('DB_NAME', 'aks'); // database name
	define('DB_USER', 'root'); // database user
	define('DB_PASSWORD', ''); // database pass

	define('DEFAULT_CONTROLLER', 'Dashboard'); // default controller if there isn't one defined in the url
	define('DEFAULT_LAYOUT', 'default'); // if no layout is set in the controller use this layout.

	define('PROOT', '/aks/'); // set this to '/' for a live server.

	define('SITE_TITLE', 'Allkeyshop'); // This will be used if no site title is set
	define('MENU_BRAND', 'AKS'); //This is the Brand text in the menu

	define('CURRENT_USER_SESSION_NAME', 'asdasdsadqweADsAd'); // session name for logged in user
	define('REMEMBER_ME_COOKIE_NAME', 'sdaasdSa3Asda'); // cookie name for logged in user remember me
	define('REMEMBER_ME_COOKIE_EXPIRY', 604800); // time in seconds for remember me cookie to live (30 days)

	define('ACCESS_RESTRICTED', 'Restricted'); //controller name for the restricted redirect

  