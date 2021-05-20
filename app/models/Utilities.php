<?php
namespace App\Models;
use Core\DB;
use Core\Input;
use Core\Model;

class Utilities{

	private $_db;
	
	public function __construct() {
		$this->_db = DB::getInstance();
  	}

	public function dataMerchant(){
		$retrieveMerchant = array();
		$sql = "SELECT vols_id, vols_nom FROM `allkeyshops`.`sale_page` ORDER BY vols_nom ASC";
		$sqlMerchant = $this->_db->query($sql)->results();
		foreach($sqlMerchant as $key => $value){
			if(!array_key_exists($value->vols_id, $retrieveMerchant)){
				$id = $value->vols_id;
				if(isset($id)) $retrieveMerchant[$id]=$value->vols_nom;
			}
		}
		return $retrieveMerchant;
	}

	public function dataEdition(){
		$retrieveEdition = array();
		$sql = "SELECT id,`name` FROM `test-server`.`pt_editions_eu`";
		$sqlEdition = $this->_db->query($sql)->results();
		foreach($sqlEdition as $key => $value){
			if(!array_key_exists($value->id, $retrieveEdition)){
				$id = $value->id;
				if(isset($id)) $retrieveEdition[$id]=$value->name;
			}
		}
		return $retrieveEdition;
	}
	
	public function dataRegion(){
		$retrieveRegions = array();
		$sql = "SELECT id,name FROM `test-server`.`pt_regions_amaurer`";
		$sqlRegions = $this->_db->query($sql)->results();
		foreach($sqlRegions as $key => $value){
			if(!array_key_exists($value->id, $retrieveRegions)) $retrieveRegions[$value->id] = $value->name;
			$retrieveRegions[6]='Gog';
			$retrieveRegions[23]='Xbox 360 Game Code';
			$retrieveRegions[24]='Xbox ONE Game Code';
		}
		return $retrieveRegions;
	}

	public function merchantEditionPriceTool($site, $getMerchantId, $getEdition){
		if ($getMerchantId == 0 AND $getEdition == 0) {
			$params = ['column' => ['`id`', '`merchant`', '`edition`', '`region`', '`normalised_name`', '`buy_url`', '`price`', '`dispo`', '`rating`', '`search_name`', '`created_by`', '`created_time`'],
				'order' => "id DESC",
				'limit' => 100,
			];
		}else{
			$params = [ 'column' => ['`id`', '`merchant`', '`edition`', '`region`', '`normalised_name`', '`buy_url`', '`price`', '`dispo`', '`rating`', '`search_name`', '`created_by`', '`created_time`'],
				'conditions' => ['merchant = ?', 'edition = ?'], 
				'bind' => [$getMerchantId, $getEdition],
				'order' => "id DESC",
				'limit' => 100,
			 ];
		}
		$result =  $this->_db->find( '`'.self::getSite($site).'`.`pt_products`',$params);
		return $result;
	}

	public static function getSite($site){
		switch ($site) {
			case 'aks':
			case 'AKS': $site = 'test-server';
			break;
			case 'cdd':
			case 'CDD': $site = 'compareprices';
			break;
			case 'brexitgbp':
			case 'BREXITGBP': $site = 'brexitgbp';
			break;
		}
		return $site;
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

	public static function query_builder( $params ){
		$url = $_SERVER["REQUEST_URI"];
		if(!isset($params) && empty($params))
			return $url;

		$queryParams = http_build_query($params);
		if (strpos($url , '?') !== FALSE) {
			$url .= '&'. $queryParams;
			$url = rtrim($url, '&');
		} else {
			$url .= '?'. $queryParams;
		}
		return $url;
	}

}

