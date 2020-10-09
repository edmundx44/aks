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
            case 'testni':

                // $sql = "select * from `aks_bot_teamph`.tblcheckerlist";
                // $stml = $db->query($sql);
                // $tes = $getInput->get('data1');
                // $tes1 = $getInput->get('kani');
                // return  $stml;
            break;

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
                $sql = "SELECT COUNT(id) as 'dataID', merchant_name FROM `checksum_feeds`.tbl_checksum where date(`lastupdate`) = '$dateNow' GROUP BY merchant_name ORDER by dataID desc limit 5";
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

            default:
            break;
        }
    }
}
