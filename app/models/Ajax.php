<?php
namespace App\Models;
use Core\Model;
use Core\DB;
use Core\Input;
use Core\Session;
use App\Models\Users;
use App\Controllers\DashboardController;
use App\Controllers\StoreController;


class Ajax {

	public static function ajaxData($post){
		$getInput = new Input();
		$db = DB::getInstance();
		date_default_timezone_set("Asia/Manila");
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
            case 'sample':
            	return 'nakoha';
            break;

            case 'displayPriceToZeroCountsCounts':

                $today = date('Y-m-d');
                $sqlAks = "SELECT AVG(percentage) as zeroPercentage FROM `test-server`.`romain_tool_zero_prices_data` WHERE DATE(`date`) = '$today'";
                $sqlCdd = "SELECT AVG(percentage) as zeroPercentage FROM `compareprices`.`romain_tool_zero_prices_data` WHERE DATE(`date`) = '$today'";

                $resultAks = $db->query($sqlAks)->results();
                $resultCdd = $db->query($sqlCdd)->results();

                foreach ($resultAks as $key) {
                    $avgAks = $key->zeroPercentage;
                }
                foreach ($resultCdd as $key) {
                    $avgCdd = $key->zeroPercentage;
                }
                $runCounts = array();
                    array_push($runCounts, array(
                        'aks' => round((float)$avgAks,2),
                        'cdd' => round((float)$avgCdd,2),
                        //'brexitgbp' =>  $avgZeroBrexit
                ));
                return $runCounts;
            break;
            
            case 'displayRealDoubleCounts':

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
                        'aks' => $db->query($sql)->count(),
                        'cdd' => $db->query($sql1)->count(),
                        //'brexitgbp' =>  $db->query($sql2)->count()
                ));
            return $runCounts;
            break;

            case 'displayRunAndSuccessAction':

                $fail = "SELECT * FROM `test-server`.`bot_admin`
                        WHERE successRunTime < DATE_ADD(NOW(), INTERVAL 4 HOUR)
                        AND (status = 1 OR status = 2) AND bot_type = 'feed'
                        ORDER by successRunTime desc";

                $success= "SELECT * FROM `test-server`.`bot_admin`
                        WHERE successRunTime > DATE_ADD(NOW(), INTERVAL 4 HOUR)
                        AND (status = 1 OR status = 2) AND bot_type = 'feed'
                        ORDER by successRunTime desc";

                $serverCharge= "SELECT * FROM `test-server`.`bot_admin`
                        WHERE successRunTime < DATE_ADD(NOW(), INTERVAL 4 HOUR)
                        AND (status = 1 OR status = 2)
                        AND bot_type = 'feed'
                        AND failed_on_server_charge = 1
                        ORDER by successRunTime desc";

                    $runSuc = array();
                        array_push($runSuc, array(
                          'fail' => $db->query($fail)->count(),
                          'success' => $db->query($success)->count(),
                          'serverCharge' => $db->query($serverCharge)->count()
                    ));
                return $runSuc;
            break;

            case 'displayCheckSumAction':
				//$dateNow = $getInput->get('dateNow'); //from ajax
                $dateTime = date('Y-m-d');
                $checksumSite = $getInput->get('checksumSite');

                $arr = file_get_contents( ROOT . DS . 'app' . DS .'getStores.json');
                $getStores = json_decode($arr, true);

                $sql = "SELECT COUNT(id) AS 'dataID', merchant_id ,lastupdate
                        FROM `aks_bot_teamph`.aks_checksum 
                        WHERE date(`lastupdate`) = '$dateTime' AND checksum_site = '$checksumSite' 
                        GROUP BY merchant_id ORDER BY lastupdate DESC limit 8";//local
                $resultCheksum = $db->query($sql)->results();
                $newChecksumDisplay = array();

                foreach ($resultCheksum as $key) {
                   if(array_key_exists($key->merchant_id, $getStores)){
                        $newChecksumDisplay[] = array(
                            'dataID' => $key->dataID,
                            'lastupdate' => strtotime($key->lastupdate),
                            'merchant_id' => $key->merchant_id,
                            'merchant_name' => $getStores[$key->merchant_id]
                        );
                   }
                }
                return $newChecksumDisplay;

			break;

			case 'displayChecksumUsingToggleSiteOnly': //toggle site
                $getWebsite = $getInput->get('getWebsiteSent'); 
                $dateNow1 = date('Y-m-d');           
                //USING INNER JOIN TO GET THE STATUS DATA IN BOT ADMIN SO THAT IT WILL DISPLAY ONLY THE STATUS 0 OR 1
                $sql1 = "SELECT aa.merchant_id, aa.checksum_data, aa.checksum_site, aa.lastupdate, tb.name, tb.website, tb.status, tb.bot_type 
                        FROM `aks_bot_teamph`.`aks_checksum` aa 
                        INNER JOIN `test-server`.`bot_admin` tb 
                        ON aa.merchant_id = tb.merchant_id AND aa.checksum_site = tb.website 
                        WHERE  (tb.status = 1 OR tb.status = 2) AND aa.checksum_site = '$getWebsite' AND tb.website = '$getWebsite' AND tb.bot_type = 'feed' ORDER BY aa.lastupdate DESC LIMIT 300";

                $sql2= "SELECT COUNT(id) as 'countToday', merchant_id, checksum_data, checksum_site FROM `aks_bot_teamph`.`aks_checksum` 
                        WHERE checksum_site = '$getWebsite' AND date(lastupdate) = '$dateNow1'
                        GROUP BY merchant_id";

                $resultFirstQuery = $db->query($sql1)->results(); //1st query
                $resultSecondQuery = $db->query($sql2)->results();; //2nd query
                $newArray1 =array();
                $mergeResult1 = array();

                foreach($resultSecondQuery as $key => $value){
                    if(!array_key_exists($value->merchant_id, $newArray1))
                        $id1 = $value->merchant_id;
                    if(isset($id1)){
                        $newArray1[$id1]=array(
                            'count' => $value->countToday,
                            'merchant_id' => $value->merchant_id
                        );
                    }          
                }

                //final result combine sql and sql1 with count
               foreach ($resultFirstQuery as $key) {
                    if(array_key_exists($key->merchant_id, $newArray1)){
                        $mergeResult1[] =array(
                            'merchant_id' => $key->merchant_id,
                            'merchant_name' => ucfirst($key->name),
                            'checksum_data' => $key->checksum_data,
                            'checksum_site' => $key->checksum_site,
                            'lastupdate' => date('M d Y h:i A',strtotime($key->lastupdate)),
                            'count' => $newArray1[$key->merchant_id]['count']
                        );
                    }else{
                        $mergeResult1[] =array(
                            'merchant_id' => $key->merchant_id,
                            'merchant_name' => ucfirst($key->name),
                            'checksum_data' => $key->checksum_data,
                            'checksum_site' => $key->checksum_site,
                            'lastupdate' => date('M d Y h:i A',strtotime($key->lastupdate)),
                            'count' => 0
                        );
                    }
                }
                    $returnData['success']= array(
                        'data' => $mergeResult1,
                        'currentPhTime' => $dateNow1
                    );
                return $returnData;
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
