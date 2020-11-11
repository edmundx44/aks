<?php
namespace App\Models;
use Core\Model;
use Core\DB;
use Core\Input;
use Core\Session;
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
                return $db->query($sql) ?  'success' :  'fail';
            break;
            case 'displayAddChangeLogAction':

                $sql = "select * from `aks_bot_teamph`.tblAddChangeLog order by id desc";
                return $db->query($sql)->results();
                break;
            case 'displayCheckSumAction':

                $dateNow = $getInput->get('dateNow');
                $sql = "SELECT COUNT(id) as 'dataID', merchant_name FROM `checksum_feeds`.tbl_checksum where date(`lastupdate`) = '$dateNow' GROUP BY merchant_name HAVING dataID > 1 limit 5";
                return $db->query($sql)->results();
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
                $merchantNi = file_get_contents(ROOT . DS . 'app' . DS . 'merchant_data.json');
                $testarr = json_decode($merchantNi, true);

                $sql = "SELECT COUNT(*) as countAll, url, storeId FROM `allkeyshop.com`.aksfeeds_offer GROUP BY storeId order by countAll DESC";
                $sql1 = "SELECT COUNT(*) as countAll, url, storeId FROM `allkeyshop.com`.aksfeeds_offer where YEAR(`createdAt`) = '2019' GROUP BY storeId";
                $sql2 = "SELECT COUNT(*) as countAll, url, storeId FROM `allkeyshop.com`.aksfeeds_offer where YEAR(`createdAt`) = '2020' GROUP BY storeId";

                $res = array();
                foreach ($db->query($sql)->results() as $key) {
                    if(array_key_exists($key->storeId,$testarr)){
                        $res[$key->storeId] = [
                            'id' => $testarr[$key->storeId]['realID'],
                            'name' => $testarr[$key->storeId]['merchatName'], 
                            'countOffers' => $key->countAll,
                            'url' => $key->url
                        ];
                    }
                }
                
                foreach ($db->query($sql1)->results() as $key) {
                    if(array_key_exists($key->storeId,$testarr)){
                        if(array_key_exists($key->storeId,$res)){
                            $res[$key->storeId][] = $key->countAll;
                        }
                    } 
                }

                foreach ($db->query($sql2)->results() as $key) {
                    if(array_key_exists($key->storeId,$testarr)){
                        if(array_key_exists($key->storeId,$res)){
                            $res[$key->storeId][] = $key->countAll;
                        }
                    } 
                }

                return $res;
            break;
            case 'testLoopAction':
                $merchantNi1 = file_get_contents(ROOT . DS . 'app' . DS . 'sample.json');
                $testarr1 = json_decode($merchantNi1, true);

                foreach ($testarr1 as $product) {
                    $price = $product['price'];
                    $stock = $product['stock'];
                    $gName = $product['name'];
                    $link = $product['link'];

                    $checkExist = "select * from `aks_bot_teamph`.`tblCheckUpdate` where `gameName` = '$gName'";
                    $checkExistResult = $db->query($checkExist)->count();

                    if($checkExistResult >= 1) {
                        $checkprice = "select `price` from `aks_bot_teamph`.`tblCheckUpdate` where `gameName` = '$gName'";
                        $checkpriceResult = $db->query($checkprice)->first();
                        $gprice = $checkpriceResult->price;
                        if($gprice != $price) {
                            $sql = "UPDATE `aks_bot_teamph`.`tblCheckUpdate`
                                    SET `price` = '$price', `action` = 'UPDATED'
                                    WHERE `gameName` = '$gName'";
                            $run = $db->query($sql); 
                            // $msg = 'e update ni'. " " . $price . " " . $gName; 
                        }
                    }else{
                       $sql = "Insert INTO  `aks_bot_teamph`.`tblCheckUpdate` 
                        ( `price`, `stock`, `gameName`, `link`, `action`) 
                        VALUES 
                        ( '$price', '$stock', '$gName', '$link', 'ADDED')";
                        $run = $db->query($sql); 
                        // $msg = 'added';
                    }
                }
                // return $msg;
            break;
            case 'testLoopDisplayAction':
                $sql = "SELECT * FROM `aks_bot_teamph`.`tblcheckupdate` order by `tblcheckupdate`.date desc";
                return $db->query($sql)->results(); 
            break;

            case 'addCMerchantAction':

                $merchantName = $getInput->get('merchantName');
                $merchantID = $getInput->get('merchantID');
                $codes = htmlspecialchars_decode($getInput->get('codes'));
                $userID = Users::currentUser()->id;

                $checkExist = "SELECT * FROM `aks`.`tblmerchant` where `merchantName` = '$merchantName' OR `merchantID` = '$merchantID'";
                $checkExistResult = $db->query($checkExist)->count();

                if($checkExistResult >= 1) {
                    $msg = "101";
                }else{
                   $sql = "Insert INTO  `aks`.`tblMerchant` 
                    ( `merchantName`, `merchantID`, `codes`, `userID`) 
                    VALUES 
                    ( '$merchantName', '$merchantID', '$codes', '$userID')";
                    $msg = $db->query($sql) ?  'success' :  'fail'; 
                }
                
                return $msg;
            break;
            case 'displayMerchantAction':
                $sql = "SELECT * FROM `aks`.`tblMerchant` where status = 1 order by id desc";
                return $db->query($sql)->results();  
            break;
            case 'displayMerchantCodesAction':
                $id = $getInput->get('id');
                $sql = "SELECT codes FROM `aks`.`tblMerchant` where status = 1 and id = '$id'";
                return $db->query($sql)->first()->codes;  
            break;
            case 'runMerchantAction':
                $code = htmlspecialchars_decode($getInput->get('codes'));
                ob_start();
                print eval('?>'. $code);
                $output = ob_get_contents();
                ob_end_clean();
                
               // delete session after using 
               // $run = Session::delete('merchantData');
                return Session::get('merchantData');
            break;

            default:
            break;
        }
    }
}
