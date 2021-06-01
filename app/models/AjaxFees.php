<?php

namespace App\Models;
use Core\Model;
use Core\DB;
use Core\Input;
use Core\Session;
use App\Models\Users;

class AjaxFees{

    public static function ajaxData($post){
        date_default_timezone_set("Asia/Manila");
        $getInput = new Input();
		$db = DB::getInstance();

        if (preg_match('/E\:/',  __DIR__) OR preg_match('/C\:/',  __DIR__)) {
            $file_location = 'vendors/assets/payment-fees.js'; //in local
        } else {
            $file_location = '/var/www/sites-eu/allkeyshop.com/blog/wp-content/plugins/aks-prices/assets/js/payment-fees.js';
        }

        switch ($post) {
            case 'aks-fees-merchant':
                $website =  $getInput->get('site');
                $param = [ $website , '1' ]; //positional
                $sql = "SELECT `id`,`merchant_name`,`merchant_id` FROM `test-server`.`aks_fees` where website = ? AND status = ? ORDER BY `merchant_name` ASC";
                return $db->query($sql, $param)->results();
            break;
            
            case 'merchantFeesToEdit':
                $id =  $getInput->get('row');
                $param = [ $id ]; //positional
                $sql = "SELECT * FROM `test-server`.`aks_fees` where id = ? LIMIT 1";
                return $db->query($sql, $param)->results();
            break;

            case 'merchantFeesToUpdate':
                $id_to_update = $getInput->get('row');
                $pp_fees = $_POST['dataFee'][0]['pp_fees'];
                $cc_fees = $_POST['dataFee'][0]['cc_fees'];

                $param = [ $pp_fees, $cc_fees, $id_to_update ]; //positional
                $sql = "UPDATE `test-server`.`aks_fees` SET `pp_fees` = ? , `cc_fees` = ? WHERE `id` = ?";
                $boolean = $db->query($sql, $param)->error();
                if(!$boolean){
                    Fees::updatePaymentFees($file_location);    //update payment fees if theres a store has been updated;
                    $boolean = true;
                }
                return $boolean;
            break;

            case 'merchantFeesAddNew':
                $website = strtolower($getInput->get('website'));
                $merchantId = $getInput->get('merchantId');
                $merchantName = $getInput->get('merchantName');
                $pp_fees = $_POST['dataFees'][0]['pp_fees'];
                $cc_fees = $_POST['dataFees'][0]['cc_fees'];
                $status = '1';

                $paramExists = [ $merchantId , $website ]; //positional
                $existsSql = "SELECT * FROM `test-server`.`aks_fees` WHERE `merchant_id` = ? AND `website` = ? LIMIT 1";
                
                $paramInsert = [ $merchantId, $merchantName, $website, $status, $pp_fees, $cc_fees ]; //positional
                $sqlInsert = "INSERT INTO `test-server`.`aks_fees` (`merchant_id`, `merchant_name`, `website`, `status` , `pp_fees` , `cc_fees`)
                              VALUES( ?, ?, ?, ?, ?, ? )";

                $count = $db->query($existsSql , $paramExists )->count();
                $boolean = false;
                if($count == 0){
                     $success = $db->query($sqlInsert , $paramInsert )->error();
                     if(!$success){
                        Fees::updatePaymentFees($file_location);  //update payment fees if theres a store has been added;
                        $boolean = true;
                     }
                }
                return $boolean;
            break;
            
            case 'removedStore':
                $id = $getInput->get('id');
                if(isset($id) && $id != ''){
                    $param = [ $id ];
                    $sql =  "DELETE FROM `test-server`.`aks_fees` WHERE id = ?";
                    $boolean = $db->query($sql, $param)->error();
                    if(!$boolean) 
                        Fees::updatePaymentFees($file_location); //update payment fees if theres a store has been removed;
                        $boolean = true;
                }
                return $boolean;
            break;

            default:
            break;
        }

    }
    //end of ajax function
}