<?php
namespace App\Controllers;
use Core\Controller;
use Core\H;
use App\Models\Users;
use App\Models\Ajax;
use Core\DB;

class StoreController extends Controller {

	public function __construct($controller, $action) {
		parent::__construct($controller, $action);
	}

	public function indexAction() {

		// $db = DB::getInstance();

		self::ajaxFunction();
		$this->view->render('admin/store/index');
	}

	public function ajaxFunction(){
		if($this->request->isPost('action')){
			$ajaxResult = Ajax::ajaxData($this->request->get('action'));
			$this->jsonResponse($ajaxResult);
		}
	}

	// public static function checkUrl($url){
	// 	$path = parse_url($url, PHP_URL_PATH);
	// 	$encoded_path = array_map('urlencode', explode('/', $path));
	// 	$url = str_replace($path, implode('/', $encoded_path), $url);

	// 	return filter_var($url, FILTER_VALIDATE_URL) ? true : false;
	// }

}
