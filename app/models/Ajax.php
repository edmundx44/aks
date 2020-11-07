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
                $inputAuthor =  ucfirst($_SESSION['username']);
                $inputMessage = $getInput->get('inputMessage');

                $sql = "Insert INTO  `aks_bot_teamph`.`tblAddChangeLog` 
                ( `inputID`, `inputDate`, `inputAuthor`, `inputMessage`) 
                VALUES 
                ( '$inputID', '$inputDate', '$inputAuthor', '$inputMessage')";
                return $db->query($sql) ?  'success' :  'fail';
            break;

            case 'displayAddChangeLogAction':

                $sql = "select * from `aks_bot_teamph`.tblAddChangeLog order by id desc";
                return $db->query($sql)->results();
            break;

            case 'displayCheckSumAction':
                //$dateNow = $getInput->get('dateNow'); //from ajax
                $dateTime = date('Y-m-d');
                $checksumSite = $getInput->get('checksumSite');

                $arr = file_get_contents( ROOT . DS . 'app' . DS .'getStores.json');
                $getStores = json_decode($arr, true);

                $sql = "SELECT COUNT(id) AS 'dataID', merchant_id 
                        FROM `aks_bot_teamph`.aks_checksum 
                        WHERE date(`lastupdate`) = '$dateTime' AND checksum_site = '$checksumSite' 
                        GROUP BY merchant_id ORDER BY dataID DESC limit 10";//local
                $resultCheksum = $db->query($sql)->results();
                $newChecksumDisplay = array();

                foreach ($resultCheksum as $key) {
                   if(array_key_exists($key->merchant_id, $getStores)){
                        $newChecksumDisplay[] = array(
                            'dataID' => $key->dataID,
                            'merchant_id' => $key->merchant_id,
                            'merchant_name' => $getStores[$key->merchant_id]
                        );
                   }
                }
                return $newChecksumDisplay;
            break;

            case 'displayChecksumUsingDateSend': //it used date //toggle site
                $dateNow = $getInput->get('getDateInput');
                $getWebsite = $getInput->get('getWebsite');

                if (isset($dateNow) && $dateNow != NULL) {
                    $dateTime = $dateNow; //from ajax
                    $dateTime = date('Y-m-d',strtotime($dateTime));
                }else
                    $dateTime = date('Y-m-d');
            
                $arr = file_get_contents( ROOT . DS . 'app' . DS .'getStores.json');
                $getStores = json_decode($arr, true);

                $sql = "SELECT * FROM `aks_bot_teamph`.`aks_checksum` 
                        WHERE id IN ( SELECT MAX(id) FROM `aks_bot_teamph`.`aks_checksum` 
                        WHERE checksum_site = '$getWebsite' AND date(lastupdate) = '$dateTime' GROUP BY merchant_id) 
                        ORDER BY lastupdate DESC";//local
                $sql1= "SELECT COUNT(id) as 'Updatedcount',merchant_id FROM `aks_bot_teamph`.`aks_checksum` 
                        WHERE checksum_site = '$getWebsite' AND date(lastupdate) = '$dateTime'
                        GROUP BY merchant_id";

                $resultCheksum = $db->query($sql)->results(); //1st query
                $objArray = $db->query($sql1); //2nd query

                if($objArray){
                    $newChecksumDisplayByDate = array();
                    $newArray =array();
                    $mergeResult = array();

                    //sql result 
                    foreach($objArray->results() as $key => $value){
                        if(!array_key_exists($value->merchant_id, $newArray))
                            $id = $value->merchant_id;
                        if(isset($id)){
                            $newArray[$id]=array(
                                'count' => $value->Updatedcount,
                                'merchant_id' => $value->merchant_id
                            );
                        }          
                    }
                    //sql 1 result 
                    foreach ($resultCheksum as $key) {
                       if(array_key_exists($key->merchant_id, $getStores)){
                            $newChecksumDisplayByDate[] = array(
                                'id' => $key->id,
                                'merchant_id' => $key->merchant_id,
                                'merchant_name' => $getStores[$key->merchant_id],
                                'checksum_data' => $key->checksum_data,
                                'checksum_site' => $key->checksum_site,
                                'lastupdate' => $key->lastupdate
                            );
                       }
                    }
                    //final result combine sql and sql1 with count
                    foreach ($newChecksumDisplayByDate as $key) {
                        if (array_key_exists($key['merchant_id'], $newArray)) {
                                $mergeResult[] =array(
                                'id' => $key['id'],
                                'merchant_id' => $key['merchant_id'],
                                'merchant_name' => $key['merchant_name'],
                                'checksum_data' => $key['checksum_data'],
                                'checksum_site' => $key['checksum_site'],
                                'lastupdate' => date('M d Y h:i A',strtotime($key['lastupdate'])),
                                'count' => $newArray[$key['merchant_id']]['count']
                            );
                        }
                    }
                    $returnResult['success']= array(
                        'data' => $mergeResult,
                        'currentPhTime' => date('Y-m-d'),
                        'dateSent' => $dateNow,
                        'websiteSent' => $getWebsite
                    );
                    return $returnResult;
                }else
                    return 'Fail';
            break;

            case 'displayChecksumUsingToggleSiteOnly': //toggle site
                $getWebsite = $getInput->get('getWebsiteSent'); 
                $dateNow1 = date('Y-m-d');           
                $checkStores = file_get_contents( ROOT . DS . 'app' . DS .'getStores.json');
                $getStores = json_decode($checkStores, true);

                $sql1 = "SELECT * FROM `aks_bot_teamph`.`aks_checksum` 
                        WHERE id IN ( SELECT MAX(id) FROM `aks_bot_teamph`.`aks_checksum` 
                        WHERE checksum_site = '$getWebsite' GROUP BY merchant_id) 
                        ORDER BY lastupdate DESC";
                $sql2= "SELECT COUNT(id) as 'countToday',merchant_id FROM `aks_bot_teamph`.`aks_checksum` 
                        WHERE checksum_site = '$getWebsite' AND date(lastupdate) = '$dateNow1'
                        GROUP BY merchant_id";

                $resultFirstQuery = $db->query($sql1)->results(); //1st query
                $resultSecondQuery = $db->query($sql2)->results();; //2nd query

                $newChecksumDisplayBySite= array();
                $newArray1 =array();
                $mergeResult1 = array();

                foreach($resultSecondQuery as $key => $value){
                    if(!array_key_exists($value->merchant_id, $newArray1))
                        $id1 = $value->merchant_id;
                    if(isset($id1)){
                        $newArray1[$id1]=array(
                            'count' => $value->countToday,
                            'merchant_id' => $value->merchant_id
                        );
                    }          
                }
                foreach ($resultFirstQuery as $key) {
                    if(array_key_exists($key->merchant_id, $getStores)){
                        $newChecksumDisplayBySite[] = array(
                            'id' => $key->id,
                            'merchant_id' => $key->merchant_id,
                            'merchant_name' => $getStores[$key->merchant_id],
                            'checksum_data' => $key->checksum_data,
                            'checksum_site' => $key->checksum_site,
                            'lastupdate' => $key->lastupdate
                        );
                    }
                }
                //final result combine sql and sql1 with count
                foreach ($newChecksumDisplayBySite as $key) {
                    if (array_key_exists($key['merchant_id'], $newArray1)) {
                        $mergeResult1[] =array(
                            'id' => $key['id'],
                            'merchant_id' => $key['merchant_id'],
                            'merchant_name' => $key['merchant_name'],
                            'checksum_data' => $key['checksum_data'],
                            'checksum_site' => $key['checksum_site'],
                            'lastupdate' => date('M d Y h:i A',strtotime($key['lastupdate'])),
                            'count' => $newArray1[$key['merchant_id']]['count']
                        );
                    }else{
                        $mergeResult1[] =array(
                            'id' => $key['id'],
                            'merchant_id' => $key['merchant_id'],
                            'merchant_name' => $key['merchant_name'],
                            'checksum_data' => $key['checksum_data'],
                            'checksum_site' => $key['checksum_site'],
                            'lastupdate' => date('M d Y h:i A',strtotime($key['lastupdate'])),
                            'count' => 0
                        );
                    }
                }
                    $returnData['success']= array(
                        'data' => $mergeResult1,
                        'currentPhTime' => $dateNow1
                    );
                return $returnData;

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
            case 'testLoopAction':
                // $merchantNi1 = file_get_contents(ROOT . DS . 'app' . DS . 'sample.json');
                // $testarr1 = json_decode($merchantNi1, true);

                // foreach ($testarr1 as $product) {
                //     $price = $product['price'];
                //     $stock = $product['stock'];
                //     $gName = $product['name'];
                //     $link = $product['link'];

                //     $checkExist = "select * from `aks_bot_teamph`.`tblCheckUpdate` where `gameName` = '$gName'";
                //     $checkExistResult = $db->query($checkExist)->count();

                //     if($checkExistResult >= 1) {
                //         $checkprice = "select `price` from `aks_bot_teamph`.`tblCheckUpdate` where `gameName` = '$gName'";
                //         $checkpriceResult = $db->query($checkprice)->first();
                //         $gprice = $checkpriceResult->price;
                //         if($gprice != $price) {
                //             $sql = "UPDATE `aks_bot_teamph`.`tblCheckUpdate`
                //                     SET `price` = '$price', `action` = 'UPDATED'
                //                     WHERE `gameName` = '$gName'";
                //             $run = $db->query($sql); 
                //             // $msg = 'e update ni'. " " . $price . " " . $gName; 
                //         }
                //     }else{
                //        $sql = "Insert INTO  `aks_bot_teamph`.`tblCheckUpdate` 
                //         ( `price`, `stock`, `gameName`, `link`, `action`) 
                //         VALUES 
                //         ( '$price', '$stock', '$gName', '$link', 'ADDED')";
                //         $run = $db->query($sql); 
                //         // $msg = 'added';
                //     }


                // }
                // return $msg;
            break;

            default:
            break;
        }
    }
}
