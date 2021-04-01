<?php
namespace App\Controllers;
use Core\Controller;
use Core\H;
use App\Models\Users;
use App\Models\Ajax;
use Core\DB;

class UtilitiesController extends Controller {

	public function __construct($controller, $action) {
		parent::__construct($controller, $action);
	}

	public function affiliateCheckAction() {
		self::ajaxFunction();
		$this->view->pageTitle = 'Affiliate Link Check';
		$this->view->render('admin/utilities/affiliate-link-check');
	}

	public function realDoubleAction() {

		self::ajaxFunction();
		$this->view->pageTitle = 'Real Double Links';
		$this->view->render('admin/utilities/real-double-links');
	}

	public function suspiciousDoubleAction() {
		self::ajaxFunction();
		$this->view->pageTitle = 'Suspicious Double Links';
		$this->view->render('admin/utilities/suspicious-double-links');
	}

	public function metacriticsDoubleAction() {
		self::ajaxFunction();
		$this->view->pageTitle = 'Metacritics Double Links';
		$this->view->render('admin/utilities/metacritics-double-links');
	}

	public function ajaxFunction(){
		if($this->request->isPost('action')){
			$ajaxResult = Ajax::ajaxData($this->request->get('action'));
			$this->jsonResponse($ajaxResult);
		}
	}

}