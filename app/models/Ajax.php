<?php
namespace App\Models;
use Core\Model;
use Core\DB;
use Core\Input;
use App\Models\Users;

class Ajax {

    public static function ajaxData($post){
        $getInput = new Input();
        $db = DB::getInstance();

        switch ($post) {
            case 'addChangeLogAction':

                $inputID = $getInput->get('inputID');
                $inputDate = $getInput->get('inputDate');
                $inputAuthor = ucfirst(Users::currentUser()->fname);
                $inputMessage = $getInput->get('inputMessage');

                $sql = "Insert INTO  `aks_bot_teamph`.`tblAddChangeLog` 
                ( `inputID`, `inputDate`, `inputAuthor`, `inputMessage`) 
                VALUES 
                ( '$inputID', '$inputDate', '$inputAuthor', '$inputMessage')";
                return $db->query($sql) ?  'success' :  'fail';;
            break;

            case 'displayAddChangeLogAction':

                $sql = "select * from `aks_bot_teamph`.tblAddChangeLog order by id desc";
                return $db->query($sql)->results();
            break;

            case 'displayCheckSumAction':

                $dateNow = $getInput->get('dateNow');
                $sql = "SELECT COUNT(id) as 'dataID', merchant_id FROM `aks_bot_teamph`.aks_checksum where date(`lastupdate`) = DATE(NOW()) AND checksum_site = 'aks' GROUP BY merchant_id limit 5";//local
                if($db->query($sql))
                    return $db->query($sql)->results();
                else
                    return '';
            break;

            case 'displayRunAndSuccessAction':

                $sql = "SELECT * FROM `test-server`.`bot_admin`
                WHERE successRunTime < DATE_ADD(NOW(), INTERVAL 6 HOUR)
                AND status = 1 AND bot_type = 'feed'
                ORDER by successRunTime desc ";

                $sql1 = "SELECT * FROM `test-server`.`bot_admin`
                WHERE successRunTime > DATE_ADD(NOW(), INTERVAL 6 HOUR)
                AND status = 1 AND bot_type = 'feed'
                ORDER by successRunTime desc ";

                $runSuc = array();
                array_push($runSuc, array(
                  'fail' => $db->query($sql)->count(),
                  'success' => $db->query($sql1)->count()
              ));
                return $runSuc;
            break;

            case 'displayOffersAction':
                $threedaysago = date('Y-m-d', strtotime(' - 3 days')) ; //64 hours
                $twodaysago = date('Y-m-d', strtotime(' - 2 days')) ; //40 hours
                $onedayago = date('Y-m-d', strtotime(' - 1 days')) ; //16 hours
                $today = date('Y-m-d', strtotime('today'));  //8 hours  

                $merchantNi = file_get_contents( ROOT . DS . 'app' . DS .'merchants_data.json');
                $testarr = json_decode($merchantNi, true);
                
                $sql = "SELECT COUNT(*) as total_offers, url, storeId 
                        FROM `allkeyshop.com`.aksfeeds_offer
                        WHERE listId != 15
                        AND listId != 14
                        AND listId != 8
                        GROUP BY storeId order by total_offers DESC";
                $sql1 = "SELECT COUNT(*) as countFeedPerStore, url, storeId, createdAt 
                        FROM `allkeyshop.com`.`aksfeeds_offer` 
                        WHERE DATE(createdAt) 
                        BETWEEN (DATE(NOW()) - INTERVAL 3 DAY) AND DATE(NOW())
                        GROUP BY DATE(createdAt),storeId ORDER BY createdAt DESC";

                $res = array();
                $arrayCountPerday = array();

                //loop the first query to get all counts offer per merchant
                foreach ($db->query($sql)->results() as $key) {
                    $countsAll = $key->total_offers;
                    $storeId = $key->storeId;
                    $res[$storeId] = [
                        'total_offers' => $countsAll,
                        'idid' => $storeId
                    ];
                }
                //return $res;

                // loop the second query to get the the count offers between today - 4 days
                foreach ($db->query($sql1)->results() as $key1) {
                    $storeIdPerday = $key1->storeId;
                    $countAllFeedPerDay = $key1->countFeedPerStore;
                    $createDatetime = date('Y-m-d', strtotime($key1->createdAt));

                    if (array_key_exists($storeId, $res)) {
                        $arrayCountPerday[$storeIdPerday]['store_Id'] = $storeIdPerday;
                        $arrayCountPerday[$storeIdPerday]['date'][$createDatetime] = $countAllFeedPerDay;
                        $arrayCountPerday[$storeIdPerday]['total_offers'] = $res[$storeIdPerday]['total_offers'];

                        //check if there a data in particular date
                        if(!array_key_exists($threedaysago, $arrayCountPerday[$storeIdPerday]['date']))
                            $arrayCountPerday[$storeIdPerday]['date'][$threedaysago] = '0';

                        if(!array_key_exists($twodaysago, $arrayCountPerday[$storeIdPerday]['date']))
                            $arrayCountPerday[$storeIdPerday]['date'][$twodaysago] = '0';

                        if(!array_key_exists($onedayago, $arrayCountPerday[$storeIdPerday]['date']))
                            $arrayCountPerday[$storeIdPerday]['date'][$onedayago] = '0';

                        if(!array_key_exists($today, $arrayCountPerday[$storeIdPerday]['date']))
                            $arrayCountPerday[$storeIdPerday]['date'][$today] = '0';
                    }
                }

                //return $arrayCountPerday;

                //combine the array 1st result query and then second result query
                foreach ($testarr as $key2) {
                    
                    if(array_key_exists($key2['storeId'],$arrayCountPerday)){
                        $arrayCountPerday[$key2['storeId']]['name'] = $key2['merchatName'];
                        $arrayCountPerday[$key2['storeId']]['realID'] = $key2['realID'];
                        $arrayCountPerday[$key2['storeId']]['store_Id'] = $key2['storeId'];
                        $arrayCountPerday[$key2['storeId']]['total_offers'] = $arrayCountPerday[$key2['storeId']]['total_offers'];
                    }
                    if(array_key_exists($key2['storeId'],$res)){
                        $arrayCountPerday[$key2['storeId']]['name'] = $key2['merchatName'];
                        $arrayCountPerday[$key2['storeId']]['realID'] = $key2['realID'];
                        $arrayCountPerday[$key2['storeId']]['store_Id'] = $key2['storeId'];
                        $arrayCountPerday[$key2['storeId']]['total_offers'] = $res[$key2['storeId']]['total_offers'];
                    }
                    // theres a merchant that no offers between today - 3 days 
                    // checks the date if set
                    // and also theres a merchant not included in arracountperday if not so theres no data yet
                    if(!array_key_exists($key2['storeId'],$arrayCountPerday)){
                        $arrayCountPerday[$key2['storeId']]['name'] = $key2['merchatName'];
                        $arrayCountPerday[$key2['storeId']]['realID'] = $key2['realID'];
                        $arrayCountPerday[$key2['storeId']]['store_Id'] = $key2['storeId'];
                        $arrayCountPerday[$key2['storeId']]['total_offers'] = '0';
                    }
                    if(!isset($arrayCountPerday[$key2['storeId']]['date'])){
                         $arrayCountPerday[$key2['storeId']]['date'][$threedaysago] = '0';
                         $arrayCountPerday[$key2['storeId']]['date'][$twodaysago] = '0';
                         $arrayCountPerday[$key2['storeId']]['date'][$onedayago] = '0';
                         $arrayCountPerday[$key2['storeId']]['date'][$today] = '0';
                    }
                }
                // reindex starting to zero
                $iZero = array_values($arrayCountPerday);
                return $iZero;

            break;

            case 'checksumStoreRun':
                
                return $getInput->get('store_receive');
                
            break;

            default:
            break;
        }
    }
}
