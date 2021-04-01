<?php
namespace App\Controllers;
use Core\Controller;
use Core\H;
use App\Models\Users;
use App\Models\Ajax;
use Core\DB;

class ToolsController extends Controller {

	public function __construct($controller, $action) {
		parent::__construct($controller, $action);
	}

	public function merchantEditionAction() {
		self::ajaxFunction();
		$this->view->pageTitle = 'Merchant edition price check tool';
		$this->view->render('admin/tools/merchant-edition');
	}

	public function priceCheckAction() {

		self::ajaxFunction();
		$this->view->pageTitle = 'Price check tool';
		$this->view->render('admin/tools/price-check');
	}

	public function rhynAction() {
		self::ajaxFunction();
		$this->view->pageTitle = 'Rhyn tool';
		$this->view->render('admin/tools/rhyn');
	}

	public function romainAction() {
		self::ajaxFunction();
		$this->view->pageTitle = 'Romain tool';
		$this->view->render('admin/tools/romain');
	}

	public function ajaxFunction(){
		if($this->request->isPost('action')){
			$ajaxResult = Ajax::ajaxData($this->request->get('action'));
			$this->jsonResponse($ajaxResult);
		}
	}

}