<?php
namespace App\Controllers;
use Core\Controller;
use Core\H;
use App\Models\Users;
use App\Models\Ajax;
use Core\DB;

class DashboardController extends Controller {

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
        $this->view->render('admin/dashboard/index');
    }
    public function activitiesAction() {

        self::ajaxFunction();
        $this->view->pageTitle = 'Activities';
        $this->view->render('admin/dashboard/activities');
    }
    public function notificationAction() {
        self::ajaxFunction();
        $this->view->pageTitle = 'Notification';
        $this->view->render('admin/dashboard/notification');
    }
    public function employeeTableAction() {

        self::ajaxFunction();
        $this->view->pageTitle = 'Notification';
        $this->view->render('admin/dashboard/employee-table');
    }

    public function ajaxFunction(){
        if($this->request->isPost('action')){
            $ajaxResult = Ajax::ajaxData($this->request->get('action'));
            $this->jsonResponse($ajaxResult);
        }
    }

}
