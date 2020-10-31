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


    // $this->view->{'VARIABLE NAME'} u can access this in views/dashboard/
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

        // $contacts = $db->find('`aks`.users', [
        //     'conditions' => "lname => '?'",
        //     'bind' => ['paulfox'],
        //     'order' => "lname",
        //     'limit' => 5
        // ]);

        // vd($contacts);

        // $sql = "select * from `aks`.users ";
        // $stmt = $db->query($sql);
        // vd($stmt-?);

        $this->view->disabledStores = $this->checkStores($db);
        $this->view->getSnapshotAks = $this->getSnapshot($db,'aks');
        $this->view->getSnapshotCdd = $this->getSnapshot($db,'cdd');
        $this->view->dbCountFeedCount = $this->dbCountFeedCount($db);
        $this->view->checksumData = $this->checkGetChecksumData($db);
        $this->view->failedStores = $this->getFailedStores($db);
        $this->view->successStores = $this->getSuccessStores($db);
        $this->view->countPerDayChecksum = $this->getCountPerDayChecksum($db);

        //vd($this->view->checksumData); //uncomment test output


        // ajax here
        if($this->request->isPost('action')){
            $ajaxResult = Ajax::ajaxData($this->request->get('action'));
            $this->jsonResponse($ajaxResult);
        }
        $this->view->render('admin/dashboard/index');
    }


    /***   FUNCTIONS FOR DASHBOARD    ***/  

    // to loop using foreach used as $key => $value always
    private function getStores($db){
        $sql = "SELECT `vols_id`,`vols_id`,`analytic_name` FROM `allkeyshops`.`sale_page` ";
        $arrayStores = $db->query($sql);
        $allStores = array();
        foreach($arrayStores->results() as $key => $value){
            if(!array_key_exists($value->vols_id, $allStores)){
                $id = $value->vols_id;
                if(isset($id))  $allStores[$id]=$value->analytic_name;
            }
        }
        return $allStores;
    }

    private function checkStores($db){
        $allStores = $this->getStores($db);
        $returnDisabledStore = array();

        $invisible_stores = json_decode(@file_get_contents('https://www.allkeyshop.com/blog/wp-content/plugins/aks-merchants/api/merchants/inactive'),true); 
        //$invisible_stores = '';
        if (FALSE !== ($invisible_stores)) {
                if(!empty($invisible_stores)){
                foreach ($invisible_stores as $stores_invisible) {
                    if(array_key_exists($stores_invisible, $allStores)){
                    $returnDisabledStore[] = array(
                        'id' => $stores_invisible,
                        'store' => $allStores[$stores_invisible]
                    );
                }else{
                    $returnDisabledStore[] = array(
                    'id' => $stores_invisible,
                    'store' => $stores_invisible
                    );
                }
            }
            return $returnDisabledStore;
        }

        }else 
            return FALSE;
    }

    private function getSnapshot($db,$website){
        $sql = "SELECT * FROM `test-server`.`bot_admin_snapshot` WHERE `website` = '$website'";
        $snapQuery = $db->query($sql);
        return $snapQuery->results();
    }

    private function dbCountFeedCount($db){
        $sql ="SELECT *, SUM((dbCount / feedCount) * 100) differences FROM `test-server`.`bot_admin` GROUP BY id ORDER BY differences ASC";
        $dbCountFeedCount = $db->query($sql);
        return $dbCountFeedCount->results();
    }

    private function getChecksumData($db){
        $sql = "SELECT * FROM `aks_bot_teamph`.`aks_checksum` WHERE id IN ( SELECT MAX(id) FROM `aks_bot_teamph`.`aks_checksum` WHERE checksum_site = 'aks' GROUP BY merchant_id) ORDER BY lastupdate DESC";
        $checksumResult = $db->query($sql);

        return $checksumResult->results();  
    }

    private function checkGetChecksumData($db){
        $getStoresData = $this->getStores($db);
        $getChecksumDataData = $this->getChecksumData($db);

        $newChecksum = array();
        foreach ($getChecksumDataData as $checksumResult){
            if(array_key_exists($checksumResult->merchant_id, $getStoresData)){
                $newChecksum[] = array(
                    'id' => $checksumResult->id,
                    'merchant_id' => $checksumResult->merchant_id,
                    'merchant_name' => $getStoresData[$checksumResult->merchant_id],
                    'checksum_data' => $checksumResult->checksum_data,
                    'checksum_site' => $checksumResult->checksum_site,
                    'lastupdate' => $checksumResult->lastupdate
                );
            }     
        }
        
        return $newChecksum;
    }

    private function getFailedStores($db){
        $sql = "SELECT * FROM `test-server`.`bot_admin` 
                WHERE successRunTime < DATE_ADD(NOW(), INTERVAL 6 HOUR)
                AND status = 1
                AND bot_type = 'feed'
                ORDER by successRunTime DESC ";
        $failedStores = $db->query($sql);
        return $failedStores->results();
    }

    private function getSuccessStores($db){
        $sql = "SELECT * FROM `test-server`.`bot_admin`
                WHERE successRunTime > DATE_ADD(NOW(), INTERVAL 6 HOUR)
                AND (status = 1 OR status = 2)
                ORDER by successRunTime DESC";

        $successStores = $db->query($sql);
        return $successStores->results();
    }

    private function getCountPerDayChecksum($db){
        $dateTime = date('Y-m-d'); 
        $sql = "SELECT COUNT(id) as 'Updatedcount',merchant_id 
                FROM `aks_bot_teamph`.`aks_checksum` 
                WHERE date(lastupdate) = '$dateTime' AND checksum_site = 'aks'
                GROUP BY merchant_id";
        $objArray = $db->query($sql);
        $newArray =array();

            foreach($objArray->results() as $key => $value){
                if(!array_key_exists($value->merchant_id, $newArray))
                    $id = $value->merchant_id;
                if(isset($id)){
                    $newArray[$id]=array(
                        'count' => $value->Updatedcount
                    );
                } 
                    
            }
            return $newArray;
    }
    
    public function objectToArray($array){
        /** first layer only **/
        return $newArray = json_decode(json_encode($array),TRUE);
    }

}
