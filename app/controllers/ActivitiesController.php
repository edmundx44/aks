<?php
namespace App\Controllers;
use Core\H;
use Core\DB;
use Core\Controller;
use App\Models\Users;
use App\Models\Ajax;


class ActivitiesController extends Controller {

    public function __construct($controller, $action) {
        parent::__construct($controller, $action);
  }

    public function actAction($queryParameters = false) {
        //$db = DB::getInstance();
        // ajax here
        self::ajaxFunction();
        //vd($this);
        $this->view->pageTitle = 'Activities';

        $this->view->render('admin/activities/activities');
    }

    public function ajaxFunction(){
		if($this->request->isPost('action')){
			$ajaxResult = Ajax::ajaxData($this->request->get('action'));
			$this->jsonResponse($ajaxResult);
		}
	}
}
