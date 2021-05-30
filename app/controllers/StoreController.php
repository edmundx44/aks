<?php
namespace App\Controllers;
use Core\Controller;

class StoreController extends Controller {

	public function __construct($controller, $action) {
		parent::__construct($controller, $action);
	}

	public function indexAction() {
		$this->view->render('admin/store/index');
	}
}
