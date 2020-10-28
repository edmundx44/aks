<?php
namespace App\Controllers;
use Core\Controller;
use Core\H;
use App\Models\Users;
use App\Models\Ajax;
use Core\DB;

class ChecksumController extends Controller {

    public function __construct($controller, $action) {
        parent::__construct($controller, $action);
  }


    // $this->view->{'VARIABLE NAME'} u can access this in views/dashboard/
    public function indexAction() {
        $db = DB::getInstance();

        $this->view->dataStores = $this->getStores($db);
        //vd($this->view->dataStores); //uncomment test output

        $this->view->render('admin/checksum/index');
    }


    private function getStores($db){
        $sql = "SELECT `vols_id`,`vols_id`,`analytic_name` FROM `allkeyshops`.`sale_page` "; 
        return $db->query($sql);
    }

}