<?php
namespace App\Controllers;
use Core\Controller;

class StatusController extends Controller {

	public function __construct($controller, $action) {
		parent::__construct($controller, $action);
	}

	public function indexAction() {
		$this->view->render('admin/status/index');
	}
}
