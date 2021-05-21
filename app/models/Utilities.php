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
		if ($getMerchantId == 0 || $getEdition == 0) {
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

	public function displayPriceToZeroCountsCounts(){
		$today = date('Y-m-d');
        $sqlAks = "SELECT AVG(percentage) as zeroPercentage FROM `test-server`.`romain_tool_zero_prices_data` WHERE DATE(`date`) = '$today'";
        $sqlCdd = "SELECT AVG(percentage) as zeroPercentage FROM `compareprices`.`romain_tool_zero_prices_data` WHERE DATE(`date`) = '$today'";
		$sqlBrexit = "SELECT AVG(percentage) as zeroPercentage FROM `brexitgbp`.`romain_tool_zero_prices_data` WHERE DATE(`date`) = '$today'";

        $resultAks = $this->_db->query($sqlAks)->results();
        $resultCdd = $this->_db->query($sqlCdd)->results();
		$resultBrexitgbp = $this->_db->query($sqlBrexit)->results();

        foreach ($resultAks as $key) {
            $avgAks = $key->zeroPercentage;
        }
        foreach ($resultCdd as $key) {
            $avgCdd = $key->zeroPercentage;
        }
		foreach ($resultBrexitgbp as $key) {
            $avgBrexitgbp = $key->zeroPercentage;
        }
        $runCounts = array();
            array_push($runCounts, array(
                'aks' => round((float)$avgAks,2),
                'cdd' => round((float)$avgCdd,2),
                'brexitgbp' => round((float)$avgBrexitgbp,2)
            ));
        return $runCounts;
	}

	public function displayRealDoubleCounts(){
		$sql = "SELECT COUNT(*) as occurs FROM `test-server`.`pt_products` 
                WHERE merchant NOT IN('1','67','157','33','333') AND normalised_name != 50 
                GROUP BY `buy_url`, `edition`, `region`, `normalised_name`, `merchant` HAVING occurs > 1";
             
        $sql1 = "SELECT COUNT(*) as occurs FROM `compareprices`.`pt_products` 
                WHERE merchant NOT IN('1','67','157','33','333') AND normalised_name != 50 
                GROUP BY `buy_url`, `edition`, `region`, `normalised_name`, `merchant` HAVING occurs > 1";
            
        // $sql2 = "SELECT COUNT(*) as occurs FROM `brexitgbp`.`pt_products` 
        //      WHERE merchant NOT IN('1','67','157','33','333') AND normalised_name != 50 
        //     GROUP BY `buy_url`, `edition`, `region`, `normalised_name`, `merchant` HAVING occurs > 1";

        $runCounts = array();
            array_push($runCounts, array(
                'aks' => $this->_db->query($sql)->count(),
                'cdd' => $this->_db->query($sql1)->count(),
                //'brexitgbp' =>  $this->_db->query($sql2)->count()
        	));
        return $runCounts;
	}

	public function displayRunAndSuccessAction(){		
        $runSuc = array();
            array_push($runSuc, array(
              'fail' => $this->feedBotFailed()->count(),
              'success' => $this->feedBotSuccess()->count(),
              'serverCharge' => $this->feedBotSuccessCharge()->count()
        ));
        return $runSuc;
	}

	public function feedBotFailed(){
		//get result ->result() || ->count() or you can find in DB.php
		$fail = "SELECT `id`,`merchant_id`,`name`,`website`,`successRunTime` FROM `test-server`.`bot_admin`
            WHERE successRunTime < DATE_ADD(NOW(), INTERVAL 4 HOUR)
            AND (status = 1 OR status = 2) AND bot_type = 'feed'
            ORDER by successRunTime desc";
		return $this->_db->query($fail);
	}

	public function feedBotSuccess(){
		//get result ->result() || ->count() or you can find in DB.php
		$success= "SELECT `id`,`merchant_id`,`name`,`website`,`successRunTime` FROM `test-server`.`bot_admin`
            WHERE successRunTime > DATE_ADD(NOW(), INTERVAL 4 HOUR)
            AND (status = 1 OR status = 2) AND bot_type = 'feed'
            ORDER by successRunTime desc";
		return $this->_db->query($success);
	}
	public function feedBotSuccessCharge(){
		//get result ->result() || ->count() or you can find in DB.php
		$serverCharge= "SELECT `id`,`merchant_id`,`name`,`website`,`successRunTime` FROM `test-server`.`bot_admin`
            WHERE successRunTime < DATE_ADD(NOW(), INTERVAL 4 HOUR)
            AND (status = 1 OR status = 2)
            AND bot_type = 'feed'
            AND failed_on_server_charge = 1
            ORDER by successRunTime desc";
		return $this->_db->query($serverCharge);
	}

	public function displayDisabledStore(){
		$sql = "SELECT `vols_id`,`vols_nom`,`analytic_name` FROM `allkeyshops`.`sale_page` ";
		$arrayStores = $this->_db->query($sql);
		$allStores = array();
		foreach($arrayStores->results() as $key => $value){
			if(!array_key_exists($value->vols_id, $allStores)){
				$id = $value->vols_id;
				if(isset($id))  $allStores[$id]=$value->analytic_name;
			}
		}

		$returnDisabledStore = array();
		$invisible_stores = json_decode(@file_get_contents('https://www.allkeyshop.com/blog/wp-content/plugins/aks-merchants/api/merchants/inactive'),true); 
		//$invisible_stores = '';
		if (FALSE !== ($invisible_stores)) {
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

				return array('to' => 'Store', 'count' => count($returnDisabledStore), 'data' => $returnDisabledStore);;
			}
		} else {
			return FALSE;
		}
	}

	public function displayDisabledMetacritics(){
		$returnResponse = array();
		$getDataMeta = file_get_contents( ROOT . DS . 'app' . DS .'metacritics_stores.json');
		$metaStores = json_decode($getDataMeta, true);

		asort($metaStores);
		foreach ($metaStores as $key) {
			$id = $key['id'];
			$name = $key['name'];
			$number_of_links = self::getMetacriticsNumberOfLinks($this->_db, $id); //# of links
			$number_of_disabled_links = self::getMetacriticsDisabledLinks($this->_db, $id); //# of disabled links

			if($number_of_links->count > 0){
				$number_of_links->count = $number_of_links->count * .95;
				if( $number_of_disabled_links->count1 >= $number_of_links->count){
					array_push($returnResponse, array(
						'id' => $id,
						'name' => $name
					));
				}
			}
		}
		return array('to' => 'Metacritics', 'count' => count($returnResponse),'data' => $returnResponse);
	}

	public function displayAllkeyshopStore(){
		$sql = "SELECT `vols_id`, `vols_nom`, `analytic_name`, `status` FROM `allkeyshops`.sale_page order by vols_nom asc";
		$result = $this->_db->query($sql)->results();
		return $result;
	}

	public function AjaxRealDblLinks($site){
		switch ($site) {
        	case 'aks':
        		 $sql = "SELECT `buy_url`, `edition`, `region`, `normalised_name`, `merchant`, COUNT(*) as occurs, `id`,`price`, `dispo` 
        	        FROM `test-server`.`pt_products` WHERE merchant NOT IN ('1','67','157','33','333') AND normalised_name != 50
        	        GROUP BY `buy_url`, `edition`, `region`, `normalised_name`, `merchant` HAVING occurs > 1 ORDER BY price DESC";
        		$returnResults = $this->_db->query($sql)->results();
        	break;
        	case 'cdd':
        		$sql = "SELECT `buy_url`, `edition`, `region`, `normalised_name`, `merchant`, COUNT(*) as occurs, `id`,`price`, `dispo` 
        	        FROM `compareprices`.`pt_products` WHERE merchant NOT IN ('1','67','157','33','333') AND normalised_name != 50
        	        GROUP BY `buy_url`, `edition`, `region`, `normalised_name`, `merchant` HAVING occurs > 1 ORDER BY price DESC";
        		$returnResults = $this->_db->query($sql)->results();
        	break;
        	case 'brexitgbp':
        		$sql = "SELECT `buy_url`, `edition`, `region`, `normalised_name`, `merchant`, COUNT(*) as occurs , `id`,`price`, `dispo` 
        	        FROM `brexitgbp`.`pt_products` WHERE merchant NOT IN ('1','67','157','33','333') AND normalised_name != 50
        	        GROUP BY `buy_url`, `edition`, `region`, `normalised_name`, `merchant` HAVING occurs > 1 ORDER BY price DESC";
        		$returnResults = $this->_db->query($sql)->results();
        	break;
        	default:
        		return "INVALID INFORMATION";
        	break;
        }
        return $returnResults;
	}

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
