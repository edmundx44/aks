<?php
namespace App\Models;
use Core\DB;
use Core\Input;
use Core\Model;

class Utilities{


    public function __construct() {

	}

    public static function db() {
        return $db = DB::getInstance();
    }


    
    /*------------------ USED THIS TO GET METACRITIC DISABLED action= "Metacritics" -------------*/
    public static function getMetacriticsNumberOfLinks($db,$id){
        $sql = "SELECT count(*) as count FROM `metacritic`.`statistics` WHERE `game_id` = $id";
        return $db->query($sql)->first();
    }
    public static function getMetacriticsDisabledLinks($db,$id){
        $sql = "SELECT count(*) as count1 FROM `metacritic`.`statistics` WHERE `game_id` = $id AND `status` = 1";
        return $db->query($sql)->first();
    }

    /*------------------ FOR AFFILIATE LINK CHECK action = "ajaxAffiliateLinkCheck" --------------*/
    public static function get_good_sqlv2($merchant_id,$affiliate_link,$dbName){
		$sql="SELECT buy_url,id,normalised_name
			FROM  `$dbName`.`pt_products` 
			WHERE  `merchant` = '$merchant_id'
			AND  `buy_url` NOT LIKE CONVERT( _utf8 '%$affiliate_link%'
			USING latin1 ) 
			AND normalised_name != 50 AND  `buy_url` != ''
			LIMIT 0 , 100";
		return $sql;
	}
	public static function loop_result($affiliate,$results,$getUrl,$getWhat,$urlCheck){
		foreach ($results as $key ) {
			if ($key->$affiliate != '') {
				$sqlarr[] = '('.$urlCheck.' != "" AND normalised_name != 50 AND merchant = '.$key->merchant_id.' AND '.$getUrl.' '.$getWhat.' LIKE "%'.htmlspecialchars_decode($key->$affiliate).'%")';
			}
		}
		return $sqlarr;
	}

}

