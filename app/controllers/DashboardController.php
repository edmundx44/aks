<?php
namespace App\Controllers;
use Core\Controller;
use App\Models\Ajax;

class DashboardController extends Controller {

    public function __construct($controller, $action) {
        parent::__construct($controller, $action);
    }

    public function indexAction() {
        // ajax here
        if($this->request->isPost('action')){
            $ajaxResult = Ajax::ajaxData($this->request->get('action'));
            $this->jsonResponse($ajaxResult);
        }
        $this->view->render('admin/dashboard/index');
    }
    public function activitiesAction() {
        $this->view->pageTitle = 'Activities';
        $this->view->render('admin/dashboard/activities');
    }
    public function notificationAction() {
        $this->view->pageTitle = 'Notification';
        $this->view->render('admin/dashboard/notification');
    }
    public function employeeTableAction() {
        $this->view->pageTitle = 'Notification';
        $this->view->render('admin/dashboard/employee-table');
    }
}
