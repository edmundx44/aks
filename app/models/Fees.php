<?php 
namespace App\Models;
use Core\DB;

class Fees
{
    
    public static function updatePaymentFees($file_location){
		$db = DB::getInstance();

        $sql = "SELECT * FROM `test-server`.`aks_fees` ";
		$results = $db->query($sql)->results();

		$json_result = [];
		$stores = [];

		foreach($results as $row){
		    $store = [];
		    $store['name'] = $row->merchant_name;
		    $store['id'] = $row->merchant_id;

		    // $store['paypal_fees'] = $row['paypal_fees'];
		    $store['pp_fees'] =  $row->pp_fees;
		    $store['cc_fees'] =  $row->cc_fees;
		    $json_result[$store['id']] = $store;
		}
		//echo '<pre>',print_r($json_result,1),'</pre>';
		$merchants = implode(",", array_keys($json_result));
		$writer = 'function get_payment_fees()';
		$writer.="\n".'{';
		    $writer.="\n\t".'var infinity = 9007199254740992';
		    $writer.="\n\t".'var shops = ['.$merchants.'];';
		    $writer.="\n\t".'fees = {};';
		    $writer.="\n\n\t".'for (var index in shops)';
		    $writer.="\n\t".'{';
		    $writer.="\n\t\t".'var shop = shops[index];';
		    $writer.="\n\t\t".'fees[shop] = {};';
		    $writer.="\n\t\t".'fees[shop][\'paypal\'] = {};';
		    $writer.="\n\t\t".'fees[shop][\'card\'] = {};';

		    $writer.="\n\n\t\t";

		        foreach($json_result as $row){
		            $pp_fees = json_decode($row['pp_fees'], TRUE);
		            $cc_fees = json_decode($row['cc_fees'], TRUE);
		            $writer.="\n\t\t";
		            $writer.='if (shop == '.$row['id'].' )';
		            $writer.="\n\t\t".'{';
		            foreach($pp_fees as $range => $fees){
		                $writer.="\n\t\t\t";
		                $writer.= "fees[shop]['paypal'][".$range."] = {};";
		                $writer.="\n\t\t\t";
		                $writer.= "fees[shop]['paypal'][".$range."]['a'] = ".self::percent_multiplier($fees[0]["percent"]) .';';
		                $writer.=  "\n\t\t\t";
		                $writer.= "fees[shop]['paypal'][".$range."]['b'] = ".$fees[0]["flat"] .';';
		            }
		            foreach($cc_fees as $range => $fees){
		                $writer.="\n\t\t\t";
		                $writer.= "fees[shop]['card'][".$range."] = {};";
		                $writer.="\n\t\t\t";
		                $writer.= "fees[shop]['card'][".$range."]['a'] = ".self::percent_multiplier($fees[0]["percent"]) .';';
		                $writer.=  "\n\t\t\t";
		                $writer.= "fees[shop]['card'][".$range."]['b'] = ".$fees[0]["flat"] .';';
		            }
		            $writer.="\n\t\t".'}'."\n";
		        }

		$writer.="\n\t".'}';
		$writer.="\n\t".'return fees;';
		$writer.="\n".'}';
		$fp = fopen($file_location, 'w');
		fwrite($fp, $writer);
		fclose($fp);

    }

    public static function percent_multiplier($num){
		return ($num + 100)/100;
	}
}
