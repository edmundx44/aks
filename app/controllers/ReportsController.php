<?php
namespace App\Controllers;
use Core\Controller;
use Core\H;
use App\Models\Users;
use App\Models\Ajax;
use Core\DB;

class ReportsController extends Controller {

	public function __construct($controller, $action) {
		parent::__construct($controller, $action);
	}

	public function indexAction() {
		// $db = DB::getInstance();

		self::ajaxFunction();
		$this->view->pageTitle = 'Reports';
		$this->view->render('admin/reports/index');
	}

	public function ajaxFunction(){
		if($this->request->isPost('action')){
			$ajaxResult = Ajax::ajaxData($this->request->get('action'));
			$this->jsonResponse($ajaxResult);
		}
	}

	public static function getPattern($merchantName){
		switch ($merchantName) {
			case 'g2a':
				// $pattern = '/(?<url>.*i\d+).*$/';
				$pattern = '/^.+\-(i\d+)\?.+/';
				// ^.*\-(i\d+)\?.*
			break;
			default:
				$pattern = '/(?<url>.*).*$/';
		}
		return $pattern;
	}
}

