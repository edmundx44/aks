<?php
namespace App\Models;
use Core\DB;
use Core\Input;
use Core\Model;

class Utilities{
	private $_db;
	public static $_checkSite = [ 'aks' , 'cdd', 'brexitgbp'];
	
	public function __construct() {
		$this->_db = DB::getInstance();
	}

	private static function getSite($site){
		switch ($site) {
			case 'aks':
			case 'AKS': $site = '`test-server`';
			break;
			case 'cdd':
			case 'CDD': $site = '`compareprices`';
			break;
			case 'brexitgbp':
			case 'BREXITGBP': $site = '`brexitgbp`';
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

	public function dataBotAdminMerchant($website){
		$displayMerchant = $this->_db->find('`test-server`.`bot_admin`',[
			'column' => ['`merchant_id`','`name`','`bot_type`','`website`','`status`',],
			'conditions' => ['website = ?', 'bot_type = ?', 'status !=?'],
			'bind' => [$website , 'feed', 0],
			'order' => 'name'
		]);
		return $displayMerchant;
	}

	public function salepageFindByStatus($data = 1 ){
		$data = [ 'pos-one' => $data ];
		$sql = "SELECT vols_id,vols_nom FROM `allkeyshops`.`sale_page` WHERE `status` = ? ORDER BY vols_nom ASC";
		return $this->_db->query( $sql, $data );
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
		$result =  $this->_db->find( ''.self::getSite($site).'.`pt_products`',$params);
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
		//		WHERE merchant NOT IN('1','67','157','33','333') AND normalised_name != 50 
		// 		GROUP BY `buy_url`, `edition`, `region`, `normalised_name`, `merchant` HAVING occurs > 1";

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
							'merchant' => ucfirst($allStores[$stores_invisible])
						);
					}else{
						$returnDisabledStore[] = array(
							'id' => $stores_invisible,
							'merchant' => ucfirst($stores_invisible)
						);
					}
				}

				return array('to' => 'Store', 'count' => count($returnDisabledStore), 'data' => $returnDisabledStore);;
			}
		} else {
			return FALSE;
		}
	}

	public function displayMetacritics(){
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
				if( $number_of_disabled_links->count1 <= $number_of_links->count){
					array_push($returnResponse, array(
						'id' => $id,
						'merchant' => ucfirst($name),
						'status' => 'enabled'
					));
				}else{
					array_push($returnResponse, array(
						'id' => $id,
						'merchant' => ucfirst($name),
						'status' => 'disabled'
					));
				}
			}
		}
		return $returnResponse;
	}

	public function displayAllkeyshopStore(){
		$sql = "SELECT `vols_id`, `vols_nom`, `analytic_name`, `status` FROM `allkeyshops`.sale_page order by vols_nom asc";
		$result = $this->_db->query($sql)->results();
		return $result;
	}

	public function AjaxRealDblLinks($site){
		$site = strtolower($site);
		if(!in_array( $site, static::$_checkSite) )
			return "INVALID INFORMATION";

		$sql = "SELECT `buy_url`, `edition`, `region`, `normalised_name`, `merchant`, COUNT(*) as occurs, `id`,`price`, `dispo` 
			FROM ".self::getSite($site).".`pt_products` WHERE merchant NOT IN ('1','67','157','33','333') AND normalised_name != 50
			GROUP BY `buy_url`, `edition`, `region`, `normalised_name`, `merchant` HAVING occurs > 1 ORDER BY price DESC";
		return $returnResults = $this->_db->query($sql)->results();
	}

	public function metacriticsErrorRating(){
		$sql = "SELECT `userid`,`url`,`game_id`,`normalised_name`,`rating_type`,`critics_score`,`users_rating_score`,`id`
			FROM `metacritic`.`statistics` 
			WHERE (critics_score > 10 OR users_rating_score > 10) 
			ORDER BY id DESC";
		return $this->_db->query($sql);
	}

	public function AjaxMetacriticsDblLinks($getCritisStore){
		if($getCritisStore == 'Default'){
			$sql = "SELECT `game_id`,`normalised_name`,`rating_type`,`game_type`,`country`, COUNT(*) AS occurs ,`id`, `date_added`, `userid`,`url`
				FROM `metacritic`.`statistics` GROUP BY `game_id`,`normalised_name`,`rating_type`,`game_type`,`country` 
				HAVING occurs > 1 ORDER BY id DESC";
		}else{
			$sql = "SELECT `game_id`,`normalised_name`,`rating_type`,`game_type`,`country`, COUNT(*) AS occurs ,`id`, `date_added`, `userid`,`url`
				FROM `metacritic`.`statistics` WHERE game_id = '$getCritisStore'
				GROUP BY `game_id`,`normalised_name`,`rating_type`,`game_type`,`country` 
				HAVING occurs > 1 ORDER BY id DESC";   
		}
		return $returnResults = $this->_db->query($sql);
	}

	public function getFeedBotData($website, $merchantId){
		$array = array();
		$origin = $_SERVER['REQUEST_SCHEME'] . '://' . $_SERVER['HTTP_HOST'];
		if($origin == 'http://localhost'){
			$fileContent = file_get_contents($origin."/allkeyshop.com/admin/bot_de_v2/bot_admin/merchant/".$website."/feedbot/".$merchantId.".php?source=adminpage");
		}else{
			$context = stream_context_create( array( 'http' => array( 'header'  => "Authorization: Basic " . base64_encode("marc:bopols714") ) ) );
			$fileContent = file_get_contents("https://www.allkeyshop.com/admin/bot_de_v2/bot_admin/merchant/".$website."/feedbot/".$merchantId.".php?source=adminpage", false, $context);
			//$fileContent = file_get_contents("https://www.allkeyshop.com/admin/bot_de_v2/bot_admin_stage/merchant/aks/feedbot/11111.php?source=adminpage", false, $context);//testing in bot_admin_stage
		}
		if($merchantId == 67){
			preg_match_all('/\D+\[(.*)\]\s.*Array\D+(\d+\.?\d?\d?)\D+(\d+)\D+\[sku\]\D+?\D\D\D(.*)/',$fileContent, $con); //para cjs	
			$links = $con[1];
				$price = $con[2];
				$stock = $con[3];
				$sku = $con[4];
				foreach ($links as $id => $value) {
					$array[] = array(
						'url' => $value,
						'sku' => $sku[$id],
						'price'  => $price[$id],
						'stock' => $stock[$id],
					);
				}
		}else{
			preg_match_all('/\[(.*)]\s.*Array\D+(\d+\.?\d?\d?)\D+(\d+)/',$fileContent, $con);
			$links = $con[1];
			$price = $con[2];
			$stock = $con[3];

			foreach ($links as $id => $value) {
				$array[] = array(
					'url' => $value,
					'price'  => $price[$id],
					'stock' => $stock[$id],
				);
			}
		}
		return $array;
	}

	public function feedSearchUrl($website, $merchantId){
		//This is from Bot Admin file get the text value function then parse the string using eval to use as function
		//Get the edit_url function 
		$origin = $_SERVER['REQUEST_SCHEME'] . '://' . $_SERVER['HTTP_HOST'];
		if($origin == 'http://localhost'){
			$path = "/xampp/htdocs/allkeyshop.com/admin/bot_de_v2/bot_admin/merchant/".$website."/feedbot/".$merchantId.".php";  
		}else{
			$context = stream_context_create(array( 'http' => array('header'  => "Authorization: Basic " . base64_encode("marc:bopols714")) ));
			$path = "/var/www/sites-eu/allkeyshop.com/admin/bot_de_v2/bot_admin/merchant/".$website."/feedbot/".$merchantId.".php";
		}

		if ($stream = fopen($path , 'r',false , $context = null ) ) { 
			$contents = stream_get_contents($stream, -1, 1);
			fclose($stream);
		}
		$contents = str_replace("\n", "", $contents);
		//$contents = str_replace("'",'"',$contents); //have a problem in ${1}
		preg_match('/(function\s+edit_url.+?;\s*\})/', $contents, $match); //\s* zero or more spaces sample ; } || ;}
		$function = preg_replace('/\/\/[^www].*?\;/','',$match[1]); 
		//then use eval([name of the function that get])
		return $function;
	}

	public function getRecentActivity($worker = '', $action = '', $site = 'aks'){
		switch ($site) {
			case 'aks':
				$leftJoin = '`test-server`';
				$qSite = 'AKS';
			break;
			case 'cdd':
				$leftJoin = '`compareprices`';
				$qSite = 'CDD';
			break;
			case 'brexitgbp':
				$leftJoin = '`brexitgbp`';
				$qSite = 'BREXITGBP';
			break;
			default: break;
		}
		if ($worker != NULL && $action != null){
			$sql = "SELECT u.id, u.worker, u.url, u.site, u.action, u.product_id, u.time, tb.normalised_name
				FROM `test-server`.`price_team_activity` u 
				LEFT JOIN 
					$leftJoin.`pt_products` tb 
					ON tb.id = u.product_id 
				WHERE u.worker = '$worker' AND u.site = '$qSite' AND u.action='$action' ORDER BY `time` DESC LIMIT 100";
		}else if($worker != NULL && $action == null){
			$sql = "SELECT u.id, u.worker, u.url, u.site, u.action, u.product_id, u.time, tb.normalised_name
				FROM `test-server`.`price_team_activity` u 
				LEFT JOIN 
					$leftJoin.`pt_products` tb 
					ON tb.id = u.product_id 
				WHERE u.worker = '$worker' AND u.site = '$qSite' ORDER BY `time` DESC LIMIT 100";
		}else if($worker == NULL && $action != null){
			$sql = "SELECT u.id, u.worker, u.url, u.site, u.action, u.product_id, u.time, tb.normalised_name
				FROM `test-server`.`price_team_activity` u 
				LEFT JOIN 
					$leftJoin.`pt_products` tb 
					ON tb.id = u.product_id 
				WHERE u.site = '$qSite' AND u.action='$action' ORDER BY `time` DESC LIMIT 100";
		}else{
			//Default if null null
			$sql = "SELECT u.id, u.worker, u.url, u.site, u.action, u.product_id, u.time, tb.normalised_name
				FROM `test-server`.`price_team_activity` u 
				LEFT JOIN 
					$leftJoin.`pt_products` tb 
					ON tb.id = u.product_id 
				WHERE u.site = '$qSite' ORDER BY `time` DESC LIMIT 100";
		}
		return $this->_db->query($sql);
	}

	public function getAllUsers($role){
		if($role != ''){
			$getCondition = 'role like ?';
			$getBind = '%'.htmlspecialchars_decode($role).'%';
		}else{
			$getCondition = '';
			$getBind = '';
		}
		return  $this->_db->find('`test-server`.`admin_user`',[
			'column' => ['`username`'],
			'conditions' => [$getCondition],
			'bind' => [$getBind],
			'order' => 'username'
		]);
	}

	public function getOfferCounts($site){
		$table = static::getSite($site);
		$sql = "SELECT merchant, count(*) AS 'count' FROM $table.`pt_products` Group By merchant";
		$results = $this->_db->query($sql)->results();
		$array = array();
		foreach($results as $key => $value){
			if(!array_key_exists($value->merchant, $array)){
				$id = $value->merchant;
				if(isset($id)) {
					$array[$id]['count'] = $value->count;
					$array[$id]['merchant'] = $id;
				};
			}
		}
		return $array;
	}
	
	public function getOfferCountsByRatings($site ,$rating){
		$data = [ 'rating' => $rating ]; //positional
		$table = static::getSite($site);
		$sql = "SELECT merchant, count(*) AS 'count' FROM $table.`pt_products` WHERE `rating` = ? Group By merchant";
		$results = $this->_db->query($sql, $data)->results();
		$array = array();
		foreach($results as $key => $value){
			if(!array_key_exists($value->merchant, $array)){
				$id = $value->merchant;
				if(isset($id)) {
					$array[$id]['count'] = $value->count;
					$array[$id]['merchant'] = $id;
				};
			}
		}
		return $array;
	}

	public function updateMerchantRating($site, $merchant, $rating){
		$data = [ $rating , $merchant ]; //positional
		$table = static::getSite($site);
		$sql = "UPDATE {$table}.`pt_products` SET `rating` = ? WHERE merchant = ? ";
		return $this->_db->query($sql, $data)->error();
	}

	public function updateMetacriticsStatus($merchant, $rating){
		$data = [ $rating , $merchant ]; //positional
		$sql = "UPDATE `metacritic`.`statistics` SET `status` = ? WHERE `game_id` = ? ";
		return $this->_db->query($sql, $data)->error();
	}

	public function userActivityCount($dateStart, $dateEnd){
		date_default_timezone_set("Asia/Manila");
		$date1 = strtotime($dateStart); //positional
		$date2 = strtotime($dateEnd.'+1 day');
		$data = [ $date1 , $date2 ];
		$sql ="SELECT COUNT(`action`) `total_per_action` ,`worker`, `action` FROM `test-server`.`price_team_activity` WHERE time >= ? AND time <= ?  GROUP by `action` , `worker`";
		return $this->_db->query($sql, $data);
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

