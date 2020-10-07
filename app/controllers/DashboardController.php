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
        
      $this->view->disabledStores = $this->checkStores($db);
      $this->view->getSnapshotAks = $this->getSnapshot($db,'aks');
      $this->view->getSnapshotCdd = $this->getSnapshot($db,'cdd');
      $this->view->dbCountFeedCount = $this->dbCountFeedCount($db);
      $this->view->checksumData = $this->getChecksumData($db);
      //vd($this->view->checksumData); //uncomment test output


      // ajax here
      if($this->request->isPost('action')){
        $ajaxResult = Ajax::ajaxData($this->request->get('action'));
        $this->jsonResponse($ajaxResult);
      }
      $this->view->render('dashboard/index');
    }

  public static function getStores($db){
    $sql = "SELECT `vols_id`,`vols_id`,`analytic_name` FROM `allkeyshops`.`sale_page` "; 
    return $db->query($sql);
  }

  public static function checkStores($db){
    $arrayStores = self::getStores($db);
    $arrayStores->results();

    $allStores = array();
    $returnDisabledStore = array();
    $invisible_stores = json_decode(@file_get_contents('https://www.allkeyshop.com/blog/wp-content/plugins/aks-merchants/api/merchants/inactive'),true); 
    if (false !== ($invisible_stores)) {
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
      return false;
    
  }

  public static function getSnapshot($db,$website){
    $sql = "SELECT * FROM `test-server`.`bot_admin_snapshot` WHERE `website` = '$website'";
    $snapQuery = $db->query($sql);
    return $snapQuery->results();
  }

  public static function dbCountFeedCount($db){
    $sql ="SELECT *, SUM((dbCount / feedCount) * 100) differences FROM `test-server`.`bot_admin` GROUP BY id ORDER BY differences ASC";
      $dbCountFeedCount = $db->query($sql);
    return $dbCountFeedCount->results();
  }

  public static function getChecksumData($db){
    $sql = "SELECT * FROM `checksum_feeds`.tbl_checksum WHERE id IN ( SELECT MAX(id) FROM `checksum_feeds`.`tbl_checksum` GROUP BY merchant_id) ORDER BY lastupdate DESC";
    $checksumResult = $db->query($sql);
    return $checksumResult->results();  
  }

}
