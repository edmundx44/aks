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

        // insert/update sample custom query
        // $fields = [
        //     'fname' => 'test',
        //     'mname' => 'test',
        //     'lname' => 'test'
        // ];
        // $run = $db->insert('tablename', $fields);
        // $run = $db->update('tablename', 'where id string or not', $fields);
            
        // delete fields 
        // $run = $db->delete('tablename', 'where id string or not');
        // to get data "->result()"
        // te get the 1st data "->first()"

        // $contacts = $db->find('`test-server`.`pt_products`',[
        //     'conditions' => ['merchant = ?'],
        //     'bind' => ['40'],
        //     'limit' => 2
        // ]);

        // vd($contacts);

        // $sql = "select * from `aks`.users ";
        // $stmt = $db->query($sql);
        // vd($stmt-?);

        //vd($this->view->countPerDayChecksum); //uncomment test output


        // ajax here
        if($this->request->isPost('action')){
            $ajaxResult = Ajax::ajaxData($this->request->get('action'));
            $this->jsonResponse($ajaxResult);
        }
        $this->view->render('admin/dashboard/index');
    }

     /*------------------ USED THIS TO GET METACRITIC DISABLED OR NOT --------------*/
    public static function getMetacriticsNumberOfLinks($db,$id){
            $sql = "SELECT count(*) as count FROM `metacritic`.`statistics` WHERE `game_id` = $id";
            return $db->query($sql)->first();
        }

    public static function getMetacriticsDisabledLinks($db,$id){
        $sql = "SELECT count(*) as count1 FROM `metacritic`.`statistics` WHERE `game_id` = $id AND `status` = 1";
        return $db->query($sql)->first();
    }
}
