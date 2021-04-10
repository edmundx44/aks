<?php
namespace App\Models;
use Core\Model;
use Core\DB;
use Core\Input;
use Core\Session;
use App\Models\Users;
use App\Models\Merchant;
use App\Controllers\DashboardController;
use App\Controllers\StoreController;
use App\Controllers\ReportsController;

class Ajax {

	public static function ajaxData($post){
		$getInput = new Input();
		$db = DB::getInstance();

		// ***** NOTE *****
		// RECOMMENDED USED ADVANCE QUERY

		// OLD STANDARD QUERY
		// USE THIS IF YOU ARE UNCERTAIN OF ADVANCE QUERY
		// $sql = "SELECT * FROM `allkeyshops`.sale_page order by vols_nom asc";
		// $result = $db->query($sql)->results();

		// ADVANCE QUERY CREATED ON CORE
		// $result =  $db->find('`test-server`.`pt_products`',[
		// 'conditions' => ['merchant = ?'],
		// 'bind' => ['40'],
		// 'limit' => 2
		// ]);
		// ***** NOTE *****

		switch ($post) {
			case 'displayReport':
				switch ($getInput->get('to')) {
					case 'menu-disabled':
						switch ($getInput->get('what')) {
							case 'Store':
								$sql = "SELECT `vols_id`,`vols_nom`,`analytic_name` FROM `allkeyshops`.`sale_page` ";
				                $arrayStores = $db->query($sql);
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
				                }else {
				                    return FALSE;
				                }

							break;
							case 'Metacritics':
								$returnResponse = array();
				                $getDataMeta = file_get_contents( ROOT . DS . 'app' . DS .'metacritics_stores.json');
				                $metaStores = json_decode($getDataMeta, true);

				                asort($metaStores);
				                foreach ($metaStores as $key) {
				                    $id = $key['id'];
				                    $name = $key['name'];
				                    
				                    $number_of_links = DashboardController::getMetacriticsNumberOfLinks($db,$id); //# of links
				                    $number_of_disabled_links = DashboardController::getMetacriticsDisabledLinks($db,$id); //# of disabled links

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
				                // return $returnResponse;
							break;
						}
					break;
					case 'menu-snapshot':
						switch ($getInput->get('what')) {
							case 'AKS':
								$addQuery = "AND `merchantID` NOT IN('1')";
							break;
							case 'CDD':
								$addQuery = "AND `merchantID` NOT IN('1','31')";
							break;
							case 'BREXIT':
								
							break;
						}

					
						
						$sql = "SELECT * FROM `test-server`.`bot_admin_snapshot` WHERE `website` = '".$getInput->get('what')."' $addQuery";
						$res = $db->query($sql)->results();
						return array('to' => $getInput->get('what'), 'count' => count($res), 'data' => $res);

					break;
					case 'menu-dbfeed':
						switch ($getInput->get('what')) {
							case 'AKS':
								$toDB = 'AKSDB';
								$toWhatDB = 'aks';
							break;
							case 'CDD':
								$toDB = 'CDDDB';
								$toWhatDB = 'cdd';
							break;
							case 'BREXIT':
								$toDB = 'BREXITDB';
								$toWhatDB = 'brexitgbp';
							break;
						}

						$sql ="SELECT *, SUM((dbCount / feedCount) * 100) differences FROM `test-server`.`bot_admin` where `dbCount` <> 0 and `website` = '".$toWhatDB."' GROUP BY id ORDER BY differences ASC";
                		$res = $db->query($sql)->results();

                		return array('to' => $toDB, 'count' => count($res),'data' => $res);

					break;
				}
			break;
			case 'displayStore':
				$sql = "SELECT * FROM `allkeyshops`.sale_page order by vols_nom asc";
				$result = $db->query($sql)->results();

				return $result;
			break;
			case 'displayStoreGames':
				$site = self::getSite($getInput->get('site'));
				$resultArray = array();
				$getOffset = $getInput->get('offset');
				$limit = ($getInput->get('limit') == 0)? 50 : $getInput->get('limit');

				if($getInput->get('toSearch') != ''){
					$conditions = "buy_url like ?";
					$getBind = '%'.htmlspecialchars_decode($getInput->get('toSearch')).'%';
				}else{
					$conditions = 'merchant = ?';
					$getBind = $getInput->get('merchantID');
				}

				$countAllByMerchant = $db->find('`'.$site.'`.`pt_products`',['conditions' => [$conditions],'bind' => [$getBind]]);
				$displayByMerchant =  $db->find('`'.$site.'`.`pt_products`',[
					'conditions' => [$conditions],
					'bind' => [$getBind],
					'order' => "price ASC",
					'limit' => $limit,
					'offset' => $getOffset
				]);
				array_push($resultArray, array(
					'total' => count($countAllByMerchant),
					'currentDisplay' => count($displayByMerchant),
					'data' => $displayByMerchant
				));

				return $resultArray;
	
			break;
			case 'displayStoreGamesByNormalizedName':
				$site = self::getSite($getInput->get('site'));

				$getNname = $getInput->get('nnameID');

				$getProductArr = array();
				$getMerchantArr = array();
				$getEditionArr = array();
				$getRegionsArr = array();

				$getMerchant = $db->find('`allkeyshops`.`sale_page`',['order' => "vols_nom ASC"]);
				$getEdition = $db->find('`'.$site.'`.`pt_editions_eu`');
				$getRegions = $db->find('`'.$site.'`.`pt_regions_amaurer`');
				$getProductByNormalisedName =  $db->find('`'.$site.'`.`pt_products`',[
					'conditions' => ['normalised_name = ?'],
					'bind' => [$getNname],
					'order' => "price ASC",
				]);

				foreach($getMerchant as $key => $value) if(!array_key_exists($value->vols_id, $getMerchantArr)) $getMerchantArr[$value->vols_id]=$value->vols_nom;
				foreach($getEdition as $key => $value) if(!array_key_exists($value->id, $getEditionArr)) $getEditionArr[$value->id]=$value->name;
				foreach($getRegions as $key => $value) {
					if(!array_key_exists($value->id, $getRegionsArr)) $getRegionsArr[$value->id] = $value->name;
					$retrieveRegions[6]='Gog';
					$retrieveRegions[23]='Xbox 360 Game Code';
					$retrieveRegions[24]='Xbox ONE Game Code';
				}

				foreach($getProductByNormalisedName as $key => $value) {
					$getMerchantArr[$value->merchant] = (!empty($getMerchantArr[$value->merchant])) ? $getMerchantArr[$value->merchant] : '';
					$getRegionsArr[$value->region]    = (!empty($getRegionsArr[$value->region])) ? $getRegionsArr[$value->region] : '';
					$getEditionArr[$value->edition]   = (!empty($getEditionArr[$value->edition])) ? $getEditionArr[$value->edition] : '';

					array_push($getProductArr, array(
						'id' 		=> $value->id, 
						'nname' 	=> $value->normalised_name, 
						'merchantID'=> $value->merchant,
						'searchName'=> $value->search_name,
						'merchant'	=> $getMerchantArr[$value->merchant],
						'region'	=> $getRegionsArr[$value->region],
						'edition'	=> $getEditionArr[$value->edition],
						'status'	=> ($value->dispo == 1)? 'In Stock' : 'Out Of Stock',
						'price'		=> $value->price,
						'buy_url'	=> $value->buy_url,
						'site'		=> $getInput->get('site')
					));
				}
				//var_dump($getProductArr);
				return $getProductArr;
			break;
			case 'storeUpdateProduct':
				$site = self::getSite($getInput->get('site'));

				switch ($getInput->get('toWhat')) {
					case 'stock':
						$stock = ($getInput->get('dataTo') == 'Out Of Stock')? 1 : 0; 
						$fields = [
							'dispo' => $stock,
						];
					break;
					case 'price':
						$fields = [
							'price' => $getInput->get('dataTo'),
						];
					break;
					
				}

				return $db->update('`'.$site.'`.`pt_products`', $getInput->get('id'), $fields);
			break;
			case 'displaySnapshot':
				$getSite = $getInput->get('website');
				
				$addQuery = ($getSite == 'CDD')? "AND `merchantID` NOT IN('1','31')" : "AND `merchantID` NOT IN('1')";
				$sql = "SELECT * FROM `test-server`.`bot_admin_snapshot` WHERE `website` = '$getSite' $addQuery";
				return $db->query($sql)->results();
		
			break;
			case 'cr-checkurl':
				preg_match('/^.*\/\/([.w]+\.+|)(.*)\.com/', $getInput->get('getUrl'), $outputMatch);
				$getPattern = ReportsController::getPattern($outputMatch[2]);
				
				preg_match($getPattern, $getInput->get('getUrl'), $matches);
				$getUrl = $matches[1];

				$sql = "SELECT * FROM tblreports WHERE `merchantLink` like '%".htmlspecialchars_decode($getUrl)."%'";
				return $db->query($sql)->results();
			break;
			case 'cr-site':
				preg_match('/^.*\/\/([.w]+\.+|)(.*)\.com/', $getInput->get('getUrl'), $outputMatch);
				$getPattern = ReportsController::getPattern($outputMatch[2]);
				
				preg_match($getPattern, $getInput->get('getUrl'), $matches);
				$getUrl = $matches[1];
				$toReturn = array();

				switch ($getInput->get('getSite')) {
					case 'AKS':
						$sqlTable = '`test-server`.`pt_products`';
					break;
					case 'CDD':
						$sqlTable = '`compareprices`.`pt_products`';
					break;
					case 'BREX':
						$sqlTable = '`brexitgbp`.`pt_products`';
					break;
				}

				$sql = "SELECT id, merchant, normalised_name, buy_url, rating FROM $sqlTable WHERE `buy_url` like '%".htmlspecialchars_decode($getUrl)."%'";
				array_push($toReturn, array(
					'site' 	=> $getInput->get('getSite'), 
					'data' 	=> $db->query($sql)->results()	
				));

				return $toReturn;
			break;
			case 'cr-submit-report':
				$toInsert = filter_var_array($_POST['toInsert']); //use native $_POST if array
				$getProblem	= $getInput->get('getProblem');

				$fieldsToInsert = array();
				$mysqlField = '`merchantSite`, `merchantSqlID`, `merchantID`, `merchantNMID`, `merchantLink`, `problem`, `status`, `rating`'; 
				foreach ($toInsert as $key) {
					$fieldsToInsert[] = '(
					 	"'.$key['merchantSite'].'",
						"'.$key['merchantSqlID'].'",
						"'.$key['merchantID'].'",
						"'.$key['merchantNMID'].'",
						"'.$key['merchantLink'].'",
						"'.$getInput->get('getProblem').'",
						"1",
						"'.$key['merchantRating'].'"
					)';
				}

                $sql = 'INSERT INTO `aks`.`tblreports` ('.$mysqlField.') VALUES '.implode(',', $fieldsToInsert).'';
                return $db->query($sql) ? true : fail;
			break;
			case 'cr-problem-list':
				$getProblemList =  $db->find('`aks`.`tblreports`',[
					'conditions' => ['status = ?'],
					'bind' => [1],
					'order' => "id DESC",
				]);
				return $getProblemList;
			break;
			case 'cr-get-cac-data':
				if($getInput->get('site') == 'BREX') {
					return $getInput->get('site'). " Not Available for the momment";
					break;
				}
				$getSiteData =  $db->find('`'.self::getSite($getInput->get('site')).'`.`pt_products`', ['conditions' => ['id = ?'], 'bind' => [$getInput->get('dataID')]]);
				$resulNi = array(
					'site' 	=> $getSiteData,
					'mfeed'	=> Merchant::merchantData($getInput->get('site'), $getInput->get('url'))
				);
				return $resulNi;
			break;
			case 'cr-rtm':
				$fields = [
					'toMerchant' => $getInput->get('reportStatus'),
				];
				return $db->update('`aks`.`tblReports`', $getInput->get('idToUpdate'), $fields);
			break;
			case 'cr-cr': 
				$fields = [
					'rating' => $getInput->get('changeRatings'),
				];
				$updateOnSite = $db->update('`'.self::getSite($getInput->get('site')).'`.`pt_products`', $getInput->get('idToUpdate'), $fields);
				$updateOnProblem = $db->update('`aks`.`tblReports`', $getInput->get('idToUpdateReport'), $fields);

			break;
		}
	}

	public static function getSite($site){
		switch ($site) {
			case 'AKS':
				$site = 'test-server';
			break;
			case 'CDD':
				$site = 'compareprices';
			break;
			case 'BREX':
				$site = 'brexitgbp';
			break;
		}
		return $site;
	}

	
}
