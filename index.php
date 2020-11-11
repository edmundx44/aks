<?php
 
  date_default_timezone_set("Asia/Manila"); //set time

  use Core\Session;
  use Core\Cookie;
  use Core\Router;
  use App\Models\Users;
  define('DS', DIRECTORY_SEPARATOR);
  define('ROOT', dirname(__FILE__));

  // load configuration and helper functions
  require_once(ROOT . DS . 'config' . DS . 'config.php');
  require_once(ROOT . DS . 'config' . DS . 'helpers.php');

  function autoload($className){
    $classAry = explode('\\',$className);
    $class = array_pop($classAry);
    $subPath = strtolower(implode(DS,$classAry));
    $path = ROOT . DS . $subPath . DS . $class . '.php';
    if(file_exists($path)){
      require_once($path);
    }
  }

  spl_autoload_register('autoload');
  session_start();

  $url = isset($_SERVER['PATH_INFO']) ? explode('/', ltrim($_SERVER['PATH_INFO'], '/')) : [];

  if(!Session::exists(CURRENT_USER_SESSION_NAME) && Cookie::exists(REMEMBER_ME_COOKIE_NAME)) {
    Users::loginUserFromCookie();
  }
  
  // Route the request
  Router::route($url);


// inside the httaccess 

// RewriteCond %{REQUEST_FILENAME} !-d = if not in a directory read on url then escape return to index.php
// RewriteCond %{REQUEST_FILENAME} !-f = if not a file from the directory on url then escape return to index.php
// RewriteCond $1 !^(config|core|css|js|fonts|robots\.txt) dont read what's on the ()

// RewriteRule ^(.+)$ index.php/$1 [L] this will be read 1st everything will loaded on index.php