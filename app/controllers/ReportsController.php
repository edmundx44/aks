<?php
namespace App\Controllers;
use Core\Controller;

class ReportsController extends Controller {

	public function __construct($controller, $action) {
		parent::__construct($controller, $action);
	}

	public function indexAction() {
		$this->view->pageTitle = 'Reports';
		$this->view->render('admin/reports/index');
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

