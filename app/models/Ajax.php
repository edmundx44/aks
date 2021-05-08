<?php
namespace App\Models;
use Core\Model;
use Core\DB;
use Core\Input;
use Core\Session;
use App\Models\Users;
use App\Models\Merchant;
use App\Models\Utilities;
use App\Controllers\DashboardController;
use App\Controllers\StoreController;
use App\Controllers\UtilitiesController;
use App\Controllers\ReportsController;

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
								} else {
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
									$number_of_links = Utilities::getMetacriticsNumberOfLinks($db,$id); //# of links
									$number_of_disabled_links = Utilities::getMetacriticsDisabledLinks($db,$id); //# of disabled links

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
								$addQuery = '';
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

				// display all but not direct all, display by 500

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
				// $getEdition = $db->find('`'.$site.'`.`pt_editions_eu`');
				// $getRegions = $db->find('`'.$site.'`.`pt_regions_amaurer`');

				$getEdition = $db->find('`test-server`.`pt_editions_eu`'); // in test-server only
				$getRegions = $db->find('`test-server`.`pt_regions_amaurer`'); // in test-server only

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
            case 'sample':
            	return 'nakoha';
            break;
            case 'displayPriceToZeroCountsCounts':

                $today = date('Y-m-d');
                $sqlAks = "SELECT AVG(percentage) as zeroPercentage FROM `test-server`.`romain_tool_zero_prices_data` WHERE DATE(`date`) = '$today'";
                $sqlCdd = "SELECT AVG(percentage) as zeroPercentage FROM `compareprices`.`romain_tool_zero_prices_data` WHERE DATE(`date`) = '$today'";
				$sqlBrexit = "SELECT AVG(percentage) as zeroPercentage FROM `brexitgbp`.`romain_tool_zero_prices_data` WHERE DATE(`date`) = '$today'";

                $resultAks = $db->query($sqlAks)->results();
                $resultCdd = $db->query($sqlCdd)->results();
				$resultBrexitgbp = $db->query($sqlBrexit)->results();

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
			case 'displayChecksumUsingToggleSiteOnly':
				
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
            case 'AjaxRealDblLinks':
                $getWebsite = $getInput->get('data');
                switch ($getWebsite) {
                	case 'aks':
                		 $sql = "SELECT `buy_url`, `edition`, `region`, `normalised_name`, `merchant`, COUNT(*) as occurs, `id`,`price`, `dispo` 
                            FROM `test-server`.`pt_products` WHERE merchant NOT IN ('1','67','157','33','333') AND normalised_name != 50
                            GROUP BY `buy_url`, `edition`, `region`, `normalised_name`, `merchant` HAVING occurs > 1 ORDER BY price DESC";
                    	$returnResults = $db->query($sql)->results();
                    	$returnSite = 'aks';
                	break;
                	case 'cdd':
                		$sql = "SELECT `buy_url`, `edition`, `region`, `normalised_name`, `merchant`, COUNT(*) as occurs, `id`,`price`, `dispo` 
                            FROM `compareprices`.`pt_products` WHERE merchant NOT IN ('1','67','157','33','333') AND normalised_name != 50
                            GROUP BY `buy_url`, `edition`, `region`, `normalised_name`, `merchant` HAVING occurs > 1 ORDER BY price DESC";
                    	$returnResults = $db->query($sql)->results();
                    	$returnSite = 'cdd';
                	break;
                	case 'brexitgbp':
                		$sql = "SELECT `buy_url`, `edition`, `region`, `normalised_name`, `merchant`, COUNT(*) as occurs , `id`,`price`, `dispo` 
                            FROM `brexitgbp`.`pt_products` WHERE merchant NOT IN ('1','67','157','33','333') AND normalised_name != 50
                            GROUP BY `buy_url`, `edition`, `region`, `normalised_name`, `merchant` HAVING occurs > 1 ORDER BY price DESC";
                    	$returnResults = $db->query($sql)->results();
                    	$returnSite = 'brexitgbp';
                	break;
                	default:
                		return "INVALID INFORMATION";
                	break;
                }
                return $returnResults;
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

				$sql = "SELECT * FROM tblreports WHERE `merchantLink` like '%".htmlspecialchars_decode($getUrl)."%' ";
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
				$mysqlField = '`merchantSite`, `merchantSqlID`, `merchantID`, `merchantNMID`, `merchantLink`, `problem`, `status`, `rating`, `checker`'; 
				foreach ($toInsert as $key) {
					$fieldsToInsert[] = '(
					 	"'.$key['merchantSite'].'",
						"'.$key['merchantSqlID'].'",
						"'.$key['merchantID'].'",
						"'.$key['merchantNMID'].'",
						"'.$key['merchantLink'].'",
						"'.$getProblem.'",
						"1",
						"'.$key['merchantRating'].'",
						"'.ucfirst(Users::currentUser()->fname).'"
					)';
				}

				$sql = 'INSERT INTO `aks`.`tblreports` ('.$mysqlField.') VALUES '.implode(',', $fieldsToInsert).'';
				return $db->query($sql) ? true : fail;
			break;
			case 'cr-problem-list':
				if($getInput->get('date') == '') {
					$getProblemList =  $db->find('`aks`.`tblreports`', ['order' => "id DESC"]);
				}else{
					$getProblemList =  $db->find('`aks`.`tblreports`',[
						'conditions' => ['status = ?', 'date(`date`) = ?'],
						'bind' => [1, $getInput->get('date')],
						'order' => "id DESC"
					]);
				}
				
				return $getProblemList;
			break;
			case 'cr-get-cac-data':
				// preg_match('/(?<url>.*i\d+).*$/', $getInput->get('url'), $matches);
				// $getUrl = $matches[1];
				$getSiteData =  $db->find('`'.self::getSite($getInput->get('site')).'`.`pt_products`', [
					'column' => ['`buy_url`', '`price`' ,'`dispo`', '`rating`'],
					'conditions' => ['id = ?'], 
					'bind' => [$getInput->get('dataID')]
				]);
				$resulNi = array(
					'site' 	=> $getSiteData,
					'mfeed'	=> Merchant::merchantData($getInput->get('site'), $getInput->get('url')),
					'msite' => Merchant::merchantSiteXpath($getInput->get('url'))
				);
				return $resulNi;
				//return $getSiteData;
				//return Merchant::merchantData($getInput->get('site'), $getInput->get('url'));
				
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
			
			case 'cr-fixed-problem':
				$getStock = ($getInput->get('mfeedStock') == 'in stock')? 1 : 0;

				switch ($getInput->get('getProblem')) {
					case 'Wrong price':
						$fields = [
							'price' => $getInput->get('mfeedPrice'),
							'rating' => 0
						];
					break;
					case 'Wrong stock':
						$fields = [
							'dispo' => $getStock,
							'rating' => 0
						];
					break;
					case 'Price to zero':
						$fields = [
							'price' => 0.00,
							'dispo' => 0,
						];
					break;
					default:
						$fields = [];
					break;
				}

				$fieldsComplete = [
					'merchantSite' => $getInput->get('getSite'),
					'merchantSqlID' => $getInput->get('getID'),
					'merchantID' => $getInput->get('getMerchantId'),
					'merchantNMID' => $getInput->get('getNormalizedName'),
					'merchantLink' => $getInput->get('getLink'),
					'problem' => $getInput->get('getProblem'),
					'siteProbs' => $getInput->get('getSiteProblem'),
					'feedProbs' => $getInput->get('getFeedProblem'),
					'msiteProbs' => $getInput->get('getmerchantSiteProbs'),
					'rating' => $getInput->get('getRating'),
					'reportFeedback' => $getInput->get('getreportFeedback'),
					'checker' => ucfirst(Users::currentUser()->fname)
				];

				$insertToComplete = $db->insert('`aks`.`tblReportsComplete`', $fieldsComplete);
				$updateOnSite = $db->update('`'.self::getSite($getInput->get('getSite')).'`.`pt_products`', $getInput->get('getID'), $fields);
				$updateOnProblem = $db->delete('`aks`.`tblReports`', $getInput->get('idToUpdateReport'));

				$logFields = [
					'productID' => $getInput->get('getID'),
					'action' => 'Fixed problem',
					'employeeID' => Users::currentUser()->id
				];
				$insertToLogs = $db->insert('`aks`.`tblLogs`', $logFields);
			break;
			case 'cr-recheck':
				switch ($getInput->get('toWhat')) {
					case 'r-swp':
						$fields = [
							'reportID' => $getInput->get('rID'),
							'reportFeedback' => $getInput->get('feedback'),
							'feedProbs' => $getInput->get('toAddProbsFeed'),
							'siteProbs' => $getInput->get('toAddProbsSite'),
							'checker' => ucfirst(Users::currentUser()->fname)
						];
						$run = $db->insert('`aks`.`tblReportRecheck`', $fields);
					break;
					case 'r-ols':
						$getSiteData =  $db->find('`aks`.`tblReportRecheck`', [
							'conditions' => ['reportID = ?'], 
							'bind' => [$getInput->get('rID')]
						]);
						return $getSiteData;
					break;
				}
			break;
			case 'cr-display-completed':
				return $db->find('`aks`.`tblReportsComplete`');
			break;
			case 'cr-reopen-problem':
				$fields = [
					'merchantSite' => $getInput->get('getcsite'),
					'merchantSqlID' =>  $getInput->get('getccmysqlid'),
					'merchantID' =>  $getInput->get('getcmid'),
					'merchantNMID' =>  $getInput->get('getcmnm'),
					'merchantLink' =>  $getInput->get('getcmlink'),
					'problem' => $getInput->get('getcproblem'),
					'status' => 1,
					'rating' => $getInput->get('getcrating'),
					'checker' => ucfirst(Users::currentUser()->fname)
				];
				$updateOnComplete = $db->delete('`aks`.`tblReportsComplete`', $getInput->get('getcid'));
				$insertOnReport = $db->insert('`aks`.`tblReports`', $fields);

				$logFields = [
					'productID' => $getInput->get('getccmysqlid'),
					'action' => 'Reopen reports',
					'employeeID' => Users::currentUser()->id
				];
				$insertToLogs = $db->insert('`aks`.`tblLogs`', $logFields);

			break;

			case 'ajaxAffiliateLinkCheck':
			    //$getInput = $getInput->get(); //get all data sent
                //$getWebsiteRequest = $getInput['site'];
                $getWebsiteRequest = $getInput->get('site');
                $url_check = $getInput->get('urlCheck');

                $noAffiliateLink = array(); //store here data with no affiliate link
                $withAffiliaLink = array(); //store here data with affiliate link

                $sql_salepage = "SELECT `analytic_name`,`vols_id` FROM `allkeyshops`.`sale_page` WHERE status = 1 ";
                $salepage_stores = $db->query($sql_salepage)->results();

                $sql_stores = "SELECT * FROM `test-server`.`affiliate_links` ";
                $stores = $db->query($sql_stores)->results();

                foreach($salepage_stores as $salepage_store){
                    if(!in_array($salepage_store->vols_id,array_column($stores,'merchant_id'))){
                        $noAffiliateLink[] = array(
                            'id' => $salepage_store->vols_id,
                            'name' => $salepage_store->analytic_name,
                            'classText' => 'txt-danger',
                        );
                    }
                }

                $totalError = 0;
                if($url_check == 'buy_url_raw'){

                    $getUrl = ($url_check == 'buy_url_raw')? 'buy_url_raw':'buy_url';
                    $getWhat = ($url_check == 'buy_url_raw')? '': 'NOT';
                    
                    $sqlarr = array();
                    if($getWebsiteRequest == 'cdd'){
                        $database= 'compareprices';
                        $aff_search = 'cdd_affiliate_link';
                        $ress = Utilities::loop_result($aff_search,$stores,$getUrl,$getWhat,$url_check);
                    }else if($getWebsiteRequest == 'brexitgbp'){
                        $database= 'brexitgbp';
                        $aff_search = 'brexit_affiliate_link';
                        $ress = Utilities::loop_result($aff_search,$stores,$getUrl,$getWhat,$url_check);
                    }else if($getWebsiteRequest == 'aks'){
                        $database= 'test-server';
                        $aff_search= 'aks_affiliate_link';
                        $ress = Utilities::loop_result($aff_search,$stores,$getUrl,$getWhat,$url_check);
                    }else{
                        return "INVALID INFORMATION";
                    }
                    //ONLY ONE REQUEST
                    $sql_2 = 'SELECT buy_url,buy_url_raw, id,normalised_name, merchant FROM `'.$database.'`.`pt_products` WHERE '.implode(' OR ', $ress).' group by merchant';
                    $results = $db->query($sql_2)->results();                    
                    
                    $result_array = array();

                    $exception_store = [504,503,513,514,163];
                    $exception =[   '?cc=us','?','?currency=USD','?currency=usd','?currency=usd&region=us','?currency=USD&region=us',
                                    '?cc=gb','?','?currency=GBP','?currency=gbp','?currency=gbp&region=gb','?currency=GBP&region=gb','?cc=eu','?',
                                    '?currency=EUR','?currency=eur','?currency=eur&region=eu','?currency=EUR&region=eu','?pid=','?variant='
                    ];
					//vd($results); //check all the result that have affiliate url then foreach to check even more errors affiliate links
                    foreach ($results as $key => $value) {
                        preg_match('/^(?<url>.+?)(\?.*|\?.*&.*)$/', $value->buy_url_raw,$container); //preg match the buy_url_raw that contains paramerter
                        if(isset($container[2])){

                            //check value of preg match url
							//if merchant is in exception store the nuse this patterns to get the value of the parameters in link
                            if(in_array($value->merchant, $exception_store) && isset($container['url']) && isset($container[0])){
                                switch ($value->merchant) {
                                    case 504: case 503: case 513: case 514:
                                        $pattern = '/.*(\?pid=).*/';
                                        break;
                                    case 163:
                                        $pattern = '/.*(\?variant=).*/';
                                        break;
                                    default:
                                    break;
                                }
                                $full_url = $container[0];
                                $match_exp_string = preg_replace($pattern, '$1',$full_url);//replace the match with match string
                                $container[2] = $match_exp_string;
                            }
							//if not in array enters here
                            if(!array_key_exists($value->merchant,$result_array)){
                                $merchant = $value->merchant;
								//if $container[2] which is the value here is the parameter of the link is in the $exception then dont include in the result
                                if(!in_array($container[2], $exception) && isset($merchant) && $merchant != '3rds 8'){
                                    $result_array[$merchant] = array(
                                        'buy_url' => $value->buy_url,
                                        'buy_url_raw' => $value->buy_url_raw,
                                        'id' => $value->id,
                                        'normalised_name' => $value->normalised_name,
                                        'merchant' => $value->merchant
                                    );
                                }   
                            }
                        }
                    }
                    //vd($result_array[47]);
                    //vd($result_array); //contains all the errors that have affiliate in buy_url_raw
					//foreach the result from the afiliate links table to get the value of affiliate in every merchant that use to display in page
                    foreach ($stores as $key => $value) {
                        $final = array();
                        $affiliate_link = $value->aks_affiliate_link;
                        $merchant_id = $value->merchant_id;
                        $name        = $value->name;

                        if($getWebsiteRequest == 'cdd'){
                            $affiliate_link = $value->cdd_affiliate_link; 
                        }else if($getWebsiteRequest == 'brexitgbp'){
                            $affiliate_link = $value->brexit_affiliate_link; 
                        }else{
                            $affiliate_link = $value->aks_affiliate_link; 
                        }

                        $count = 0;
                        $classType= 'alert-v2 alert-success-v2';
                        $totalError = $totalError + $count;
						//if the $merchant_id is in the $result_array then put an error class
                        if(array_key_exists($merchant_id, $result_array)){
                            $final[] = $result_array[$merchant_id];
                            $count = 1;
                            $classType = ($count == 1) ? 'alert-v2 alert-warning-v2' : '';
                            $totalError = $totalError + $count;
                        }
                        array_push($withAffiliaLink, array(
                                    'classType' => $classType,
                                    'aff_link' => htmlspecialchars($affiliate_link),
                                    'mer_id' => $merchant_id,
                                    'data' => $final,
                                    'name' => $name,
                                    'count' => $count
                                )
                            );
                    }
                }else{
                    //if $url_check is buy_url 
                    //Based on how many stores then as is for request
                    foreach ($stores as $key => $value) {
                        $merchant_id    = $value->merchant_id;
                        $name           = $value->name;
                        $affiliate_link = $value->aks_affiliate_link; //if empty cdd and brexit it uses this default aks;

                        if($getWebsiteRequest == 'aks'){
                            if($value->aks_affiliate_link != NULL){
                                $affiliate_link = $value->aks_affiliate_link; 
                            }
                            $resultAff = $db->query(Utilities::get_good_sqlv2($merchant_id,$affiliate_link,'test-server'))->results();
                        }elseif($getWebsiteRequest == 'cdd'){
                            if($value->cdd_affiliate_link != NULL){
                                $affiliate_link = $value->cdd_affiliate_link; 
                            }
                            $resultAff = $db->query(Utilities::get_good_sqlv2($merchant_id,$affiliate_link,'compareprices'))->results();
                        }elseif($getWebsiteRequest == 'brexitgbp'){
                            if($value->brexit_affiliate_link != NULL){
                                $affiliate_link = $value->brexit_affiliate_link; 
                            }
                            $resultAff = $db->query(Utilities::get_good_sqlv2($merchant_id,$affiliate_link,'brexitgbp'))->results();
                        }else{
                            return "INVALID INFORMATION";
                        }

                            $count = count($resultAff);
                            $totalError = $totalError + $count;
                            if($count ==0)
                                $classType= 'alert-v2 alert-success-v2';
                            else
                                $classType= 'alert-v2 alert-warning-v2';

                            array_push($withAffiliaLink, array(
                                    'classType' => $classType,
                                    'aff_link' => htmlspecialchars($affiliate_link),
                                    'mer_id' => $merchant_id,
                                    'data' => $resultAff,
                                    'count' => $count,
                                    'name' => $name
                                )
                            );
                    }
                    
                }

                    $returnResult['success'] = array(
                        'withAffiliaLink' => $withAffiliaLink,
                        'noAffiliateLink' => $noAffiliateLink,
                        'site' => $getWebsiteRequest,
                        'totalError' => $totalError,
                        'url_check' => $url_check
                    );

                    return $returnResult;
			break;
			
			case 'affMoreInfo':
                $getSite = $getInput->get('website');
                $getId = $getInput->get('merchant_id');
                $getafflink = htmlspecialchars_decode($getInput->get('afflink'));
                $name = $getInput->get('mer_name');
                $showUrl = ($getInput->get('toUrl') == 'buy_url')? 'buy_url':'buy_url_raw';
                $getWhat = ($getInput->get('toUrl') == 'buy_url')? 'not' : '';

                switch ($getSite) {
                    case 'aks':
                        $databaseTo = 'test-server';
                    break;
                    case 'cdd':
                        $databaseTo = 'compareprices';
                    break;
                    case 'brexitgbp':
                        $databaseTo = 'brexitgbp';
                    break;
                }
                if($getId == '122'){ $getafflink = 'html?'; }
                    $sql = 'SELECT '.$showUrl.', id,normalised_name, merchant FROM `'.$databaseTo.'`.`pt_products` where '.$showUrl.' != "" and normalised_name != "50" and merchant = '.$getId.' and '.$showUrl.' '.$getWhat.' like "%'.$getafflink.'%" LIMIT 0,100';
                    $results = $db->query($sql)->results();
                    $returnArray['success'] = array(
                        'merchant' => $getId,
                        'name' => ucfirst($name),
                        'data' => $results,
                        'type' =>  $showUrl
                    );
                    return $returnArray['success'];
            break;

			case 'getFailedStores':
                $sql = "SELECT `id`,`merchant_id`,`name`,`website`,`successRunTime` FROM `test-server`.`bot_admin` 
                        WHERE successRunTime < DATE_ADD(NOW(), INTERVAL 4 HOUR)
                        AND (status = 1 OR status = 2)
                        AND bot_type = 'feed'
                        ORDER by successRunTime DESC ";
                $failedStores = $db->query($sql)->results();
                $returnFStores = array();
                foreach ($failedStores as $key) {
                    $returnFStores[] = array(
                        'merchant_id' => $key->merchant_id,
                        'successRunTime' => $key->successRunTime,
                        'name' => $key->name,
                        'website' => $key->website,
                        'successRunTime' => date('M d Y h:i A',strtotime($key->successRunTime))
                    );
                }
                return $returnFStores;
            break;

            case 'getSuccessStores':
                $sql = "SELECT `id`,`merchant_id`,`name`,`website`,`successRunTime` FROM `test-server`.`bot_admin`
                        WHERE successRunTime > DATE_ADD(NOW(), INTERVAL 4 HOUR)
                        AND (status = 1 OR status = 2)
                        AND bot_type = 'feed'
                        ORDER by successRunTime DESC";
                $successStores = $db->query($sql)->results();
                $returnSStores = array();
                foreach ($successStores as $key) {
                    $returnSStores[] = array(
                        'merchant_id' => $key->merchant_id,
                        'successRunTime' => $key->successRunTime,
                        'name' => $key->name,
                        'website' => $key->website,
                        'successRunTime' => date('M d Y h:i A',strtotime($key->successRunTime))
                    );
                }
                return $returnSStores;
            break;

            case 'getServerChargeStore':
                $sql = "SELECT `id`,`merchant_id`,`name`,`website`,`successRunTime` FROM `test-server`.`bot_admin`
                        WHERE successRunTime < DATE_ADD(NOW(), INTERVAL 4 HOUR)
                        AND (status = 1 OR status = 2) 
                        AND failed_on_server_charge = 1
                        AND bot_type = 'feed'
                        ORDER by successRunTime DESC";

                $serverChargeStore = $db->query($sql)->results();
                $returnSCStores = array();
                foreach ($serverChargeStore as $key) {
                    $returnSCStores[] = array(
                        'merchant_id' => $key->merchant_id,
                        'successRunTime' => $key->successRunTime,
                        'name' => $key->name,
                        'website' => $key->website,
                        'successRunTime' => date('M d Y h:i A',strtotime($key->successRunTime))
                    );
                }
                return $returnSCStores;
            break;

			//END
			case 'cr-remove-report':
				$updateOnProblem = $db->delete('`aks`.`tblReports`', $getInput->get('idToRemove'));
			break;
			case 'display-notification':

// 				

				// $getlogs =  $db->find('`aks`.`tblLogs`', [
				// 	'conditions' => ['status = ?'], 
				// 	'bind' => [0]
				// ]);

				
				// return $getlogs;

				$sql = "SELECT `s`.`id`,`s`.`productID`,`s`.`action`, `u`.`fname`, `t`.`merchant`, `p`.`vols_nom` 
							FROM `aks`.`tbllogs` `s`
    							INNER JOIN `aks`.`users` `u` ON `s`.`employeeID` = `u`.`id`
    							INNER JOIN `test-server`.`pt_products` `t` ON `s`.`productID`  = `t`.`id`
								inner join `allkeyshops`.`sale_page` `p` ON `t`.`merchant` = `p`.`vols_id`  
								where `s`.`status` = 0";
				return $db->query($sql)->results();

			break;
			case 'update-notifiction':
				$fields = [
					'status' => 1,
				];
				$logUpdate = $db->update('`aks`.`tblLogs`', $getInput->get('id'), $fields);
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
