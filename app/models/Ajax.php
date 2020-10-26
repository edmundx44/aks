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

            default:
            break;
        }
    }
}
