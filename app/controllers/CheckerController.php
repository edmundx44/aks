<?php
namespace App\Controllers;
use Core\Controller;
use Core\H;
use App\Models\Users;
use App\Models\Ajax;
use Core\DB;

class CheckerController extends Controller {

	public function __construct($controller, $action) {
		parent::__construct($controller, $action);
	}

	public function indexAction() {
		$db = DB::getInstance();

		// ajax here
        if($this->request->isPost('action')){
            $ajaxResult = Ajax::ajaxData($this->request->get('action'));
            $this->jsonResponse($ajaxResult);
        }
        
		$this->view->render('admin/checker/index');
	}
}
