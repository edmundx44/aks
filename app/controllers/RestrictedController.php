<?php
namespace App\Controllers;
use Core\Controller;
use Core\Router;
use App\Models\Users;

class RestrictedController extends Controller {
	public function __construct($controller, $action) {
		parent::__construct($controller, $action);
	}

	public function indexAction($queryParameters = false) {
		if(!Users::currentUser()) {
			Router::redirect('user/login');
		}
		$this->view->render('restricted/index');
	}
	public function badUrlAction($queryParameters = false){
		$this->view->render('restricted/badUrl');
	}

	public function badTokenAction(){
		$this->view->render('restricted/badToken');
	}
}
