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

        $this->view->disabledStores = $this->checkStores($db);
        $this->view->getSnapshotAks = $this->getSnapshot($db,'aks');
        $this->view->getSnapshotCdd = $this->getSnapshot($db,'cdd');
        $this->view->dbCountFeedCount = $this->dbCountFeedCount($db);
        $this->view->checksumData = $this->getChecksumData($db);
        $this->view->failedStores = $this->getFailedStores($db);
        $this->view->successStores = $this->getSuccessStores($db);
        $this->view->countPerDayChecksum = $this->getCountPerDayChecksum($db);

        //vd($this->view->countPerDayChecksum); //uncomment test output


        // ajax here
        if($this->request->isPost('action')){
            $ajaxResult = Ajax::ajaxData($this->request->get('action'));
            $this->jsonResponse($ajaxResult);
        }
        $this->view->render('dashboard/index');
    }


    /***   FUNCTIONS FOR DASHBOARD    ***/  

    private function getStores($db){
        $sql = "SELECT `vols_id`,`vols_id`,`analytic_name` FROM `allkeyshops`.`sale_page` "; 
        return $db->query($sql);
    }

    private function checkStores($db){
        $arrayStores = self::getStores($db);
        $arrayStores->results();

        $allStores = array();
        $returnDisabledStore = array();
        $invisible_stores = json_decode(@file_get_contents('https://www.allkeyshop.com/blog/wp-content/plugins/aks-merchants/api/merchants/inactive'),true); 
        //$invisible_stores = '';
        if (FALSE !== ($invisible_stores)) {
            foreach($arrayStores->results() as $key => $value){
                if(!array_key_exists($value->vols_id, $allStores)){
                $id = $value->vols_id;
                if(isset($id))  $allStores[$id]=$value->analytic_name;
            }
                }//return $allStores;
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
        $sql = "SELECT * FROM `checksum_feeds`.tbl_checksum WHERE id IN ( SELECT MAX(id) FROM `checksum_feeds`.`tbl_checksum` GROUP BY merchant_id) ORDER BY lastupdate DESC";
        $checksumResult = $db->query($sql);

        return $checksumResult->results();  
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
        $sql = "SELECT COUNT(id) as 'Updatedcount',merchant_id,merchant_name 
                FROM `checksum_feeds`.`tbl_checksum` 
                WHERE date(lastupdate) = date(now()) 
                GROUP BY merchant_id,merchant_name";
        $objArray = $db->query($sql);
        $newArray =array();

            foreach($objArray->results() as $key => $value){
                if(!array_key_exists($value->merchant_id, $newArray))
                    $id = $value->merchant_id;
                if(isset($id)){
                    $newArray[$id]=array(
                        'name' => $value->merchant_name,
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
