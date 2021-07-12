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
use App\Controllers\ToolsController;
use App\Controllers\LinksController;
use App\Controllers\ReportsController;
use App\Models\Product;
use App\Models\AffiliateUrlUtility;
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
				$utilities = new Utilities;

				switch ($getInput->get('to')) {
					case 'menu-disabled':
						switch ($getInput->get('what')) {
							case 'Store':
								return $utilities->displayDisabledStore();
							break;
							case 'Metacritics':
								$getDisabled = $utilities->displayMetacritics();
								$returnResponse = array();
								foreach($getDisabled as $key){
									if($key['status'] == 'disabled'){
										array_push($returnResponse, $key);
									}
								}
								return array('to' => 'Metacritics', 'count' => count($returnResponse),'data' => $returnResponse);
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
				$utilities = new Utilities;
				return $utilities->displayAllkeyshopStore();
			break;
			case 'displayStoreGames':
				//display all
				$site = self::getSite($getInput->get('site'));
				$resultArray = array();
				$getOffset = $getInput->get('offset');
				$limit = ($getInput->get('limit') == 0)? 499 : $getInput->get('limit');

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
			case 'productUpdateStock':
				$site = self::getSite($getInput->get('site'));
				$acceptValue = [0,1];
				$boolean = false;
				if(in_array((int)$getInput->get('stock'), $acceptValue) || isset($site)){
					$stock = ((int)$getInput->get('stock') === 1)? 0 : 1; 
					$fields = [ 'dispo' => $stock ];
					$boolean = $db->update('`'.$site.'`.`pt_products`', $getInput->get('id'), $fields);
				}
				return $boolean;
			break;
			case 'productUpdatePrice':
				$site = self::getSite($getInput->get('site'));
				$price = (float)$getInput->get('price');
				$fields = [ 'price' => $price ];
				return $db->update('`'.$site.'`.`pt_products`', $getInput->get('id'), $fields);
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
			case 'displayPriceToZeroCountsCounts':
				$utilities = new Utilities;
				return $utilities->displayPriceToZeroCountsCounts();
			break;
			case 'displayRealDoubleCounts':
				$utilities = new Utilities;
				return $utilities->displayRealDoubleCounts();
			break;
			case 'displayRunAndSuccessAction':
				$utilities = new Utilities;
				return $utilities->displayRunAndSuccessAction();
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
					if(!array_key_exists($value->merchant_id, $newArray1))$id1 = $value->merchant_id;
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
							'merchant_name' => $getStores[$key->merchant_id]['name2']
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

				// $logFields = [
				// 	'productID' => $getInput->get('getID'),
				// 	'action' => 'Fixed problem',
				// 	'employeeID' => Users::currentUser()->id
				// ];
				// $insertToLogs = $db->insert('`aks`.`tblLogs`', $logFields);
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

				// $logFields = [
				// 	'productID' => $getInput->get('getccmysqlid'),
				// 	'action' => 'Reopen reports',
				// 	'employeeID' => Users::currentUser()->id
				// ];
				// $insertToLogs = $db->insert('`aks`.`tblLogs`', $logFields);
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
					$exception =[   
						'?cc=us','?','?currency=USD','?currency=usd','?currency=usd&region=us','?currency=USD&region=us',
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
							if($value->aks_affiliate_link != NULL)$affiliate_link = $value->aks_affiliate_link;
							$resultAff = $db->query(Utilities::get_good_sqlv2($merchant_id,$affiliate_link,'test-server'))->results();
						}elseif($getWebsiteRequest == 'cdd'){
							if($value->cdd_affiliate_link != NULL)$affiliate_link = $value->cdd_affiliate_link;
							$resultAff = $db->query(Utilities::get_good_sqlv2($merchant_id,$affiliate_link,'compareprices'))->results();
						}elseif($getWebsiteRequest == 'brexitgbp'){
							if($value->brexit_affiliate_link != NULL) $affiliate_link = $value->brexit_affiliate_link; 
							$resultAff = $db->query(Utilities::get_good_sqlv2($merchant_id,$affiliate_link,'brexitgbp'))->results();
						}else{
							return "INVALID INFORMATION";
						}

						$count = count($resultAff);
						$totalError = $totalError + $count;
						if($count ==0) $classType= 'alert-v2 alert-success-v2';
						else $classType= 'alert-v2 alert-warning-v2';

						array_push($withAffiliaLink, array(
							'classType' => $classType,
							'aff_link' => htmlspecialchars($affiliate_link),
							'mer_id' => $merchant_id,
							'data' => $resultAff,
							'count' => $count,
							'name' => $name
						));
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
				if($getId == '122') $getafflink = 'html?';
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
			case 'ajaxAffiliateLinkIdRequest':
				$getIdRequest = $getInput->get('ajaxRequestId');
				$sql = "SELECT * FROM `test-server`.`affiliate_links` WHERE `merchant_id` = $getIdRequest LIMIT 1";
				$result = $db->query($sql)->results();
				return $result; 
			break;
			case 'ajaxAffiliateEditRequest':
				$getIdRequestId = $getInput->get('ajaxRequestId');
				$getIdRequestName = $getInput->get('ajaxRequestName');
				$getIdRequestAks = htmlspecialchars_decode($getInput->get('ajaxRequestAks'));
				$getIdRequestCdd = htmlspecialchars_decode($getInput->get('ajaxRequestCdd'));
				$getIdRequestBrexitgbp = htmlspecialchars_decode($getInput->get('ajaxRequestBrexitgbp'));
				$getIdRequestsite = $getInput->get('ajaxRequestsite');

				$sql = "UPDATE `test-server`.`affiliate_links`
					SET `aks_affiliate_link` = '$getIdRequestAks',
						`cdd_affiliate_link` = '$getIdRequestCdd',
						`brexit_affiliate_link` = '$getIdRequestBrexitgbp',
						`name` = '$getIdRequestName'
					WHERE `merchant_id` = '$getIdRequestId'";

				$result = $db->query($sql) ? true : fail;
				if($result){
					$returnResponse['success'] = array(
						'data' => 'Successfully edited for '.ucfirst($getIdRequestName).' '.$getIdRequestId.' affialiate link',
						'site' => $getIdRequestsite
					);
				} else{
					$returnResponse['success'] = array(
						'data' => 'There something wrong with the query',
						'site' => $getIdRequestsite
					);
				}
				return $returnResponse;
			break;
			case 'addNewAffRequest':
				$getIdRequestIdAdd = $getInput->get('ajaxRequestIdAdd');
				$getIdRequestNameAdd = $getInput->get('ajaxRequestNameAdd');
				$getIdRequestAksAdd = htmlspecialchars_decode($getInput->get('ajaxRequestAksAdd'));
				$getIdRequestCddAdd = htmlspecialchars_decode($getInput->get('ajaxRequestCddAdd'));
				$getIdRequestBrexitgbpAdd = htmlspecialchars_decode($getInput->get('ajaxRequestBrexitgbpAdd'));

				$sql ="INSERT INTO `test-server`.`affiliate_links` ( `merchant_id`, `name`, `aks_affiliate_link`, `cdd_affiliate_link`,`brexit_affiliate_link`)
					VALUES ( '$getIdRequestIdAdd', '$getIdRequestNameAdd', '$getIdRequestAksAdd', '$getIdRequestCddAdd', '$getIdRequestBrexitgbpAdd')";

				$result = $db->query($sql) ? true : fail;

				if($result) return 'SUCCESS';
				else return 'SOMETHING WRONG WITH THE QUERY';
			break;
			case 'getFailedStores':
				$utilities = new Utilities;
				$failedStores = $utilities->feedBotFailed()->results();
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
				$utilities = new Utilities;
				$successStores = $utilities->feedBotSuccess()->results();
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
				$utilities = new Utilities;
				$serverChargeStore = $utilities->feedBotSuccessCharge()->results();
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
			case 'cr-remove-report':
				$updateOnProblem = $db->delete('`aks`.`tblReports`', $getInput->get('idToRemove'));
			break;
			case 'display-notification':
				// $getlogs =  $db->find('`aks`.`tblLogs`', [
				// 	'conditions' => ['status = ?'], 
				// 	'bind' => [0]
				// ]);
				// return $getlogs;
				$sql = "SELECT `s`.`id`,`s`.`productID`,`s`.`action`, `s`.`site`, `u`.`fname`, `t`.`merchant`, `p`.`vols_nom` 
							FROM `aks`.`tblNotification` `s`
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
				$notificationUpdate = $db->update('`aks`.`tblNotification`', $getInput->get('id'), $fields);
			break;
			case 'merchant_edition_price_tool':
				$postSite = ($getInput->get('website') != null ) ? $getInput->get('website') : null ;
				$postMerchant = ($getInput->get('merchant') != null) ? $getInput->get('merchant'): 0;
				$postEdition = ($getInput->get('edition') != null) ? $getInput->get('edition') : 0;
				if($postSite == null) return false;

				$utilities = new Utilities;
				$retrieveMerchant = $utilities->dataMerchant();
				$retrieveEdition = $utilities->dataEdition();
				$retrieveRegions = $utilities->dataRegion();
				$retrieveResults = $utilities->merchantEditionPriceTool($postSite, $postMerchant, $postEdition);

				$arrayThis =array();
				if(!empty($retrieveResults)){
					foreach ($retrieveResults as $key){
						$merchantData = (!array_key_exists($key->merchant, $retrieveMerchant)) ? 'No Data' : $retrieveMerchant[$key->merchant];
						$editionData = (!array_key_exists($key->edition, $retrieveEdition)) ? 'No Data' : $retrieveEdition[$key->edition];
						$regionData = (!array_key_exists($key->region, $retrieveRegions)) ? 'No Data' : $retrieveRegions[$key->region];

						array_push($arrayThis, array(
								'id' => $key->id,
								'merchant' => ucfirst($merchantData),
								'edition' => ucfirst($editionData),
								'region' => ucfirst($regionData),
								'game_id' => $key->normalised_name,
								'buy_url' => htmlspecialchars($key->buy_url),
								'price' => $key->price,
								'dispo' => $key->dispo,
								'rating' => $key->rating,
								'search_name' => htmlspecialchars($key->search_name),
								'created_by' => ucfirst($key->created_by),
								'created_time' => date('M d Y h:i A',strtotime($key->created_time.'+8 hours')),
							)
						);
					}
				}
				$returnArrayData['success'] = array(
					'data' => $arrayThis,
					'returnWebsite'=> $postSite
				);
				return $returnArrayData;
			break;
			case 'metacriticsErrorRating':
				$utilities = new Utilities;
				return $utilities->metacriticsErrorRating()->results();
			break;
			case 'AjaxMetacriticsDblLinks':
				$utilities = new Utilities;
				$getCritisStore = $getInput->get('criticStore');
				$arrayMetacritics=[
					'27' => 'Steam Metacritic', '25' => 'Amazon Metacritics', 
					'21' => 'Meristation', '8' => 'Metacritics','4' => 'Jeuxvideo',
					'1'  => 'Gamekult',   '17' => 'Everyeye',   '9' => 'Gamespot',
					'15' => 'PC Games',   '24' => '24', '26' => '26'
				];
				$newDataResult = array();
				if($getCritisStore == 'Default'){
					$arrayFinal = $utilities->AjaxMetacriticsDblLinks($getCritisStore)->results();
				}else{
					if(array_key_exists($getCritisStore, $arrayMetacritics)){
						$arrayFinal = $utilities->AjaxMetacriticsDblLinks($getCritisStore)->results();
					}else{
						return "Invalid Information";
					}
				}
				if(!empty($arrayFinal)){
					foreach ($arrayFinal as $result) {
						if(!empty($result)){
							$created_time = date('M d Y', strtotime($result->date_added));
							$url = htmlspecialchars($result->url);
							if(!array_key_exists($result->game_id, $arrayMetacritics))
								$merchantData = "Cannot Find Merchant ". $result->game_id;
							else
								$merchantData = $arrayMetacritics[$result->game_id];  
						}
						$newDataResult[] = array(
							'id' => $result->id,
							'game_id' => $result->game_id,
							'game_idname' => $merchantData,
							'url' => $url,
							'country' => $result->country,
							'userid' => $result->userid,
							'normalised_name' => $result->normalised_name,
							'game_type' => $result->game_type,
							'date_added' => $created_time
						);
					}
				}
				return $newDataResult;
			break;
			case 'pc-cda-div':
				$result = array();

				$countAllCheckerActivity = $db->find('`aks_bot_teamph`.`tblCheckerList`');
				$displayCheckerActivity = $db->find('`aks_bot_teamph`.`tblCheckerList`', [
					'order' => 'id desc',
					'limit' => 100,
					'offset'=> 0
				]);

				array_push($result, array(
					'total' => count($countAllCheckerActivity),
					'data' => $displayCheckerActivity
				));

				return $result;
			break;
			case 'displayAllDailyActivity':
				$result = array();
				$x = 0;
				$total = $getInput->get('getTotal');
				$offset = $getInput->get('getOffset');

				while($x != $total) {
					if($x == $offset) {
						$displayCheckerActivity = $db->find('`aks_bot_teamph`.`tblCheckerList`', [
							'order' => 'id desc',
							'limit' => 499,
							'offset'=> $offset
						]);
						array_push($result, array(
							'data' => $displayCheckerActivity
						));

						if($total < $offset) break;
						$offset = $offset + 499;
					}
					$x++;
				}

				return $result;
			break;
			case 'displayMoreDailyActivity':
				$offset = $getInput->get('getOffset');
				return $db->find('`aks_bot_teamph`.`tblCheckerList`', [
					'order' => 'id desc',
					'limit' => 100,
					'offset'=> $offset
				]);
			break;
			case 'pc-cda-search-data':
				$sql = "SELECT * from `aks_bot_teamph`.`tblCheckerList` search where CONCAT(search.checkerName, ' ', search.checkerActivity) like '%".htmlspecialchars_decode($getInput->get('toSearch'))."%' order by id  desc limit 100";
				return $db->query($sql)->results();
			break;
			case 'display-assign-checker':
				return $db->find('`aks_bot_teamph`.`tblAssignChecker`', [
					'conditions' => ['status = ?'],
					'bind' => [0],
					'order' => 'id desc'
				]);
			break;
			case 'displayChecker':
				return $db->find('`test-server`.`admin_user`', [
					'column' => ['`id`', '`username`', '`role`'],
					'conditions' => ['role = ?'],
					'bind' => ['price_team']
				]);
			break;
			case 'add-shift':
				if($getInput->get('toEditId') != ''){
					$fields = [
						'assignChecker' => $getInput->get('assignChecker'),
						'weekdaySchedule' => $getInput->get('weekdaySchedule'),
						'sundaySchedule' => $getInput->get('sundaySchedule'),
					];	
					$updateShift = $db->update('`aks_bot_teamph`.`tblAssignChecker`', $getInput->get('toEditId'), $fields);
				}else{
					$fields = [
						'assignChecker' => $getInput->get('assignChecker'),
						'weekdaySchedule' => $getInput->get('weekdaySchedule'),
						'sundaySchedule' => $getInput->get('sundaySchedule'),
						'assignBy' => ucfirst(Users::currentUser()->fname)
					];
					$addShift = $db->insert('`aks_bot_teamph`.`tblAssignChecker`', $fields);
				}
			break;
			case 'pc-removed-assign-checker':
				$updateShift = $db->update('`aks_bot_teamph`.`tblAssignChecker`', $getInput->get('idToRemove'), ['status' => 1]);
			break;
			case 'display-daily-listing':
				return $db->find('`aks_bot_teamph`.`tblPriceCheckTool`', [
					'conditions' => ['status = ?'],
					'bind' => [0],
					'order' => 'id desc',
				]);
			break;
			case 'check-gameID-availability':
				$displayDailyListing = $db->find('`aks_bot_teamph`.`tblPriceCheckTool`', [
					'conditions' => ['gameId = ?'],
					'bind' => [$getInput->get('toCheck')]
				]);
				return ($displayDailyListing)? '00' : '11';
			break;
			case 'add-daily-listing':
				if($getInput->get('toEditId') != ''){
					$fields = [
						'gameId' => $getInput->get('gameId'),
						'gameName' => $getInput->get('gameName'),
						'releaseDate' => $getInput->get('releaseDate')
					];	
					$updateADL = $db->update('`aks_bot_teamph`.`tblPriceCheckTool`', $getInput->get('toEditId'), $fields);
				}else{
					$fields = [
						'gameId' => $getInput->get('gameId'),
						'gameName' => $getInput->get('gameName'),
						'createdBy' => ucfirst(Users::currentUser()->fname),
						'releaseDate' => $getInput->get('releaseDate')
					];
					$addADL = $db->insert('`aks_bot_teamph`.`tblPriceCheckTool`', $fields);
				}
			break;
			case 'pc-removed-daily-listing':
				$updateShift = $db->update('`aks_bot_teamph`.`tblPriceCheckTool`', $getInput->get('idToRemove'), ['status' => 1]);
			break;
			case 'display-wrong-affilliate-link':
				return $db->find('`aks_bot_teamph`.`tblWrongAffLink`', [
					'conditions' => ['status = ?'],
					'bind' => [0],
					'order' => 'id desc'
				]);
			break;
			case 'get-wrong-affilliate-daily':
				$sql = "SELECT DATE_FORMAT(`addedDate`, '%Y-%m-%d') FROM `aks_bot_teamph`.`tblWrongAffLink` WHERE DATE_FORMAT(`addedDate`, '%Y-%m-%d') = CURDATE()";
				return ($db->query($sql)->results())? '11' : '00';
			break;
			case 'add-wrong-aff-link':
				$run = ($getInput->get('toEditId') != '')? $db->update('`aks_bot_teamph`.`tblWrongAffLink`', $getInput->get('toEditId'), ['wrongAffLink' => $getInput->get('wrongAffLink')]) : $db->insert('`aks_bot_teamph`.`tblWrongAffLink`', ['wrongAffLink' => $getInput->get('wrongAffLink')]);
			break;
			case 'displayAddChangeLogAction':
				return $db->find('`aks_bot_teamph`.`tblAddChangeLog`', [
					'order' => 'id desc'
				]);
			break;
			case 'addChangeLogAction':
				$fields = [
					'inputID' => $getInput->get('inputID'),
					'inputDate' => $getInput->get('inputDate'),
					'inputAuthor' => ucfirst(Users::currentUser()->fname),
					'inputMessage' =>  $getInput->get('inputMessage')
				];
				$insertChangelog = $db->insert('`aks_bot_teamph`.`tblAddChangeLog`', $fields);
			break;
			case 'fd-display-merchant':
				$utilities = new Utilities;
				return $utilities->dataBotAdminMerchant($getInput->get('website'));
			break;
			case 'fd-get-data':
				$site = $getInput->get('website');
				$id =   $getInput->get('id');
				$utilities = new Utilities;
				if( in_array( $id ,array_column($utilities->dataBotAdminMerchant($site),'merchant_id')) ){
					return $utilities->getFeedBotData($site, $id);
				}else{
					return "No merchant found";
				}
			break;
			case 'feed-search':
				$url = trim($getInput->get('link'));
				$site = trim($getInput->get('website'));
				$id = trim($getInput->get('id'));

				$utilities = new Utilities;
				$function = $utilities->feedSearchUrl($site,$id);
				if(!empty($function)){
					eval($function);
					$parseUrl = edit_url($url);
				}else
					$parseUrl = '';
				return $parseUrl;
			break;
			case 'recent-activity':
				$utilities = new Utilities;
				$result = $utilities->getRecentActivity( $getInput->get('employee'), $getInput->get('useraction'), $getInput->get('website') );
				return $result->results();
			break;
			case 'display-employee':
				$utilities = new Utilities;
				return $utilities->getAllUsers(trim($getInput->get('getRole')));
			break;
			case 'user-activities':
				$utilities = new Utilities;
				$ddS = explode("-", $getInput->get('dateStart'));
				$ddE = explode("-", $getInput->get('dateEnd'));
				$boolStart = checkdate ( $ddS[1] , $ddS[2] , $ddS[0] );
				$boolEnd = checkdate ( $ddE[1] , $ddE[2] , $ddE[0] );
				if( ($boolStart && $boolEnd) == true && strtotime($getInput->get('dateStart')) < strtotime($getInput->get('dateEnd')) )
					$results = $utilities->userActivityCount($getInput->get('dateStart'), $getInput->get('dateEnd'))->results();
				else
					return [];
				$final_array = array();
				foreach ($results as $activity){
				$activity->worker = ucfirst($activity->worker);
				if(!empty($activity->worker)){
					if(array_key_exists($activity->worker,$final_array)){
						$final_array[$activity->worker][$activity->action] = $activity->total_per_action;
					}else{
							$final_array[$activity->worker] = array(
									$activity->action => $activity->total_per_action,
									'worker' => $activity->worker,
								);
							}
						}
				}
				return $final_array;
			break;
			case 'display-real-double-link':
				$site = self::getSite($getInput->get('site'));
				$sql = "SELECT `buy_url`, `edition`, `region`, `normalised_name`, `merchant`, COUNT(*) as occurs, `id`,`price`, `dispo` 
					FROM `".$site."`.`pt_products` WHERE merchant NOT IN ('1','67','157','33','333') AND normalised_name != 50
					GROUP BY `buy_url`, `edition`, `region`, `normalised_name`, `merchant` HAVING occurs > 1 ORDER BY price DESC";

				return $db->query($sql)->results();
			break;
			case 'delete-real-double-link':
				$site = self::getSite($getInput->get('site'));
				$getId = $_POST['getId'];

				switch ($getInput->get('getWhat')) {
					case 'bySelected':
						foreach ($getId as $id) $deleterealDouble = $db->delete('`'.$site.'`.`pt_products`', $id);
					break;
					case 'byOne':
						$deleterealDouble = $db->delete('`'.$site.'`.`pt_products`', $getId);
					break;
				}
			break;
			case 'get-metacritics-status':
				$utilities = new Utilities;
				$response = $utilities->displayMetacritics();
				return array('to' => 'critics' , 'data' => $response);
			break;
			case 'get-stores-status':
				$utilities = new Utilities;
				$site = $getInput->get('site');
				$status = 1;  //static
				$rating = 101; //static

				if(!self::getSite($site)) return "Invalid Information";

				$stores = $utilities->salepageFindByStatus($status)->results();
				$over_all_links_count  = $utilities->getOfferCounts($site);
				$over_all_rating_count = $utilities->getOfferCountsByRatings($site, $rating);
				$response = array();

				foreach($stores as $store){
					$total_count_by_store=0;
					$total_rating_by_store=0;
						
					if(isset($over_all_links_count[$store->vols_id]['count'])) $total_count_by_store = $over_all_links_count[$store->vols_id]['count'];
					if(isset($over_all_rating_count[$store->vols_id]['count'])) $total_rating_by_store = $over_all_rating_count[$store->vols_id]['count'];

					if($total_count_by_store > 0){
						$total_count_by_store = $total_count_by_store * .95;
						if( $total_rating_by_store <= $total_count_by_store){
							array_push($response, $array = [
								'id' => $store->vols_id, 'merchant' => ucfirst($store->vols_nom), 'status'   => 'enabled'
							]);
						}else{
							array_push($response, $array = [
								'id' => $store->vols_id, 'merchant' => ucfirst($store->vols_nom), 'status'   => 'disabled'
							]);
						}
					}
				}
				return array('to' => 'merchant' , 'data' => $response);
			break;
			case 'update-statuscontroller':
				$merchant = $getInput->get('id');
				$status = $getInput->get('status');
				$from = $getInput->get('from');
				$utilities = new Utilities;

				switch($from){
					case 'merchants':
						$site = $getInput->get('site');
						if(!self::getSite($site)) return "Invalid Information";
						$rating = ($status === 'ON') ? '101' : '0' ;
						$response = $utilities->updateMerchantRating($site, $merchant, $rating); //return boolean if the return is false its success
					break;
					case 'critics':
						$rating = ($status === 'ON') ? '1' : '2' ;
						$response = $utilities->updateMetacriticsStatus($merchant, $rating); //return boolean if the return is false its success
					break;
					default:
					break;
				}
				return $response;
			break;
			case 'display-suspicious-double':
				$site = self::getSite($getInput->get('site'));
				$getMerchant = ($getInput->get('getMerchant') != '')? "AND merchant = '".$getInput->get('getMerchant')."'" : '';
				$getOffset = ($getInput->get('getOffset') != '')? $getInput->get('getOffset') : 0 ;
				$getlimit = ($getInput->get('getlimit') != '')?	$getInput->get('getlimit') : 499; //if not limit not 50 display all data
					
				$sql = "SELECT  merchant, normalised_name, edition, region, count(*) AS occurences, 
						buy_url, id, price, dispo, search_name, created_by, created_time FROM `$site`.pt_products WHERE
						merchant != '1'   AND merchant != '67' AND 
						merchant != '157' AND merchant != '33' AND
						merchant != '333' AND merchant != '3' AND normalised_name != '50' $getMerchant
					GROUP BY merchant, normalised_name, edition, region
					HAVING occurences > 1 ORDER BY price DESC LIMIT $getOffset, $getlimit";

				return  $db->query($sql)->results();
			break;
			case 'display-suspicious-double-total':
				$site = self::getSite($getInput->get('site'));
				$getMerchant = ($getInput->get('getMerchant') != '')? "AND merchant = '".$getInput->get('getMerchant')."'" : '';

				$sqlTotal = "SELECT  count(*) AS occurences
					FROM `$site`.pt_products WHERE
						merchant != '1'   AND merchant != '67' AND 
						merchant != '157' AND merchant != '33' AND
						merchant != '333' AND merchant != '3' AND normalised_name != '50' $getMerchant
						GROUP BY merchant, normalised_name, edition, region
						HAVING occurences > 1";

					return count($db->query($sqlTotal)->results());
			break;
			case 'aks-rhyn-tool':
				$utilities = new Utilities;
				return $utilities->priceTeam()->results();
			break;

			case 'rhyn-tool-display':
				if(!self::getSite($getInput->get('site'))) return [];
				$utilities = new Utilities;

				$responseSite = strtoupper($getInput->get('site'));
				$table = '`'.self::getsite($getInput->get('site')).'`.`pt_products`';
				$priceTeam = $getInput->get('priceTeam');
				$rawResults = $utilities->priceTeamActivity( $getInput->get('site'), $getInput->get('priceTeam') );
				$finalResults = [];

				if(!empty($rawResults['id_container'])){
					$query_id = implode("," ,$rawResults['id_container']); //LIMIT 100 only here
					$sql = "SELECT pt.`id`, pt.`merchant`, pt.`edition`, pt.`region`, pt.`normalised_name`, pt.`buy_url`, pt.`price`, pt.`dispo`, pt.`search_name`, pt.`created_by`, pt.`created_time`, 
							`region`.`name` as region_name,
							`edition`.`name` as edition_name
							FROM $table as pt
							LEFT JOIN `test-server`.`pt_regions_amaurer` as `region` ON `region`.`id` = pt.`region`
							LEFT JOIN `test-server`.`pt_editions_eu` as `edition` ON `edition`.`id` = pt.`edition`
							WHERE pt.`id` in ($query_id) AND region.`locale` = 'en' ORDER BY pt.`created_time` DESC LIMIT 100";
					$finalResults = $db->query($sql)->results();
				}
				$response['success'] = array( 'data' => $finalResults, 'site' => $responseSite);
				return $response;
			break;

			case 'rating-list':
				if(!self::getSite($getInput->get('website'))) return [];
				$utilities = new Utilities;

				$offset = $getInput->get('offset');
				$rating = $getInput->get('rating');
				$website = $getInput->get('website');
				$merchant = ($getInput->get('merchant') == 'Default') ? '' :  $getInput->get('merchant');
					$totalRatings = 0;

				if($rating == 'tba'){
					$finalResults = $utilities->getDisplayTbaPrices($merchant, $website, $offset);
					$totalRatings = (empty($merchant)) ? $utilities->getTotalTbaPrices($website)[0]->count : $utilities->getTotalTbaPricesByMerchant($merchant, $website)[0]->count;
				}else{
					$finalResults = $utilities->getDisplayByRatings($rating, $merchant, $website, $offset);
					$totalRatings = (empty($merchant)) ? $utilities->getTotalbyRating($rating, $website)[0]->count : $utilities->getTotalRatingByMerchant($rating, $website, $merchant)[0]->count;
				}
				$responseContainer =array();
				if(!empty($finalResults)){
					$retrieveMerchant = $utilities->dataMerchant();
					$retrieveEdition = $utilities->dataEdition();
					$retrieveRegions = $utilities->dataRegion();
					foreach ($finalResults as $key){
						$merchantData = (!array_key_exists($key->merchant, $retrieveMerchant)) ? 'No Data' : $retrieveMerchant[$key->merchant];
						$editionData = (!array_key_exists($key->edition, $retrieveEdition)) ? 'No Data' : $retrieveEdition[$key->edition];
						$regionData = (!array_key_exists($key->region, $retrieveRegions)) ? 'No Data' : $retrieveRegions[$key->region];
							array_push($responseContainer, array(
								'id' => $key->id,
								'merchant' => ucfirst($merchantData),
								'edition' => ucfirst($editionData),
								'region' => ucfirst($regionData),
								'game_id' => $key->normalised_name,
								'buy_url' => htmlspecialchars($key->buy_url),
								'price' => (float)$key->price,
								'dispo' => (int)$key->dispo,
								'search_name' => htmlspecialchars($key->search_name),
								'created_time' => date('M d Y h:i A',strtotime($key->created_time))
							)
						);
					}
				}
				$response['success'] = array( 'data' => $responseContainer, 'offset' => $offset, 'total' => $totalRatings);
				return $response;
			break;
			case 'append-merchants':
				$utilities = new Utilities;
				return $utilities->getDataMerchant();
			break;
			case 'search-rating-list':
				$utilities = new Utilities;
				$rating = $getInput->get('rating');
				$website = $getInput->get('website');
				$search = $getInput->get('toSearch');
				
				$totalRatings = 0;
				$responseContainer =array();

				$rating = ($rating == 'tba') ? '' : $rating ;
				$finalResults = $utilities->searchRatingOffers($rating, $website, $search);
				if(!empty($finalResults))
					$totalRatings = count($finalResults);
					
				$response['success'] = array( 'data' => $finalResults, 'total' => $totalRatings);
				return $response;
			break;
				
			case 'main-search-product':
				$site = self::getSite($getInput->get('site'));
				if(!is_numeric($getInput->get('toSearch'))){
					$getWhere = '`buy_url` like "%'.htmlspecialchars_decode($getInput->get('toSearch')).'%"  OR `search_name` like "%'.htmlspecialchars_decode($getInput->get('toSearch')).'%"';
				}else {
					$getWhere = '`normalised_name` = "'.htmlspecialchars_decode($getInput->get('toSearch')).'"';
				}
				
				$sql = "SELECT `s`.`id`, `s`.`merchant`, `p`.`vols_nom`, `s`.`buy_url`, `s`.`normalised_name` 
					FROM `$site`.`pt_products` `s`
					inner join `allkeyshops`.`sale_page` `p` ON `s`.`merchant` = `p`.`vols_id`
					WHERE $getWhere";
				return $db->query($sql)->results();
			break;
			case 'get-product-info':

				$site = self::getSite($getInput->get('site'));
				$toGet = $getInput->get('toGet');
				$getEuUsaDisc = ($getInput->get('site') == 'CDD')? 'description-eu' : 'description-usa';

				$sql = "SELECT 
						`id`,
						`merchant`, 
						`search_name`,
						`edition`,
						`normalised_name`,
						`price`,
						`region`,
						`rating`,
						`buy_url`,
						`keyword`,
						`category`,
						`buy_url_raw`,
						`buy_url_bis`,
						`buy_url_tier`,
						`releasedate`,
						`metacritic_score`,
						`metacritic_critic_score`,
						`metacritic_user_score`,
						`buy_url_4`,
						`releaseyear`,
						`metacritic_count`,
						`metacritic_critic_count`,
						`metacritic_user_count`,
						`image_url`,
						`description`,
						`$getEuUsaDisc` AS descriptionEuUsa,
						`description-ru` AS descriptionRu,
						`description-fr` AS descriptionFr,
						`description-de` AS descriptionDe,
						`description-es` AS descriptionEs,
						`description-it` AS descriptionIt,
						`description-pt` AS descriptionPt,
						`description-nl` AS descriptionNl
					FROM `$site`.`pt_products` 
					WHERE `id` = $toGet";

				return $db->query($sql)->results();
			break;
			case 'get-region':
				return $db->find('`test-server`.`pt_regions_amaurer`',[
					'column' => ['id', 'name'],
					'conditions' => ['locale = ?'],
					'bind' => ['en'],
					'order' => 'name asc'
				]);
			break;
			case 'get-edition':
				return $db->find('`test-server`.`pt_editions_eu`',[
					'column' => ['id', 'name']
				]);
			break;
			case 'get-merchant':
				return $db->find('`allkeyshops`.`sale_page`',[
					'column' => ['vols_id', 'vols_nom'],
					'order' => 'vols_nom ASC'
				]);
			break;
			case 'get-visible':
				$getvisibility = [];
				$sql = "SELECT `aksV`.ref_id, `aksV`.active, `aksM`.site, `aksM`.value 
					FROM `test-server`.aks_visibility_meta as `aksM`
					INNER JOIN `test-server`.aks_visibility as `aksV`
						ON `aksV`.id = `aksM`.ref_id
					WHERE `aksM`.site = 'allkeyshop_com' OR `aksM`.site = 'reviewitusa' OR `aksM`.site = 'allkeyshop_com_gbp' 
					GROUP BY `aksM`.ref_id, `aksM`.site ORDER BY `aksV`.ref_id";
		        
		        $results = $db->query($sql)->results();
				foreach($results as $key){
					$getvisibility[$key->ref_id][$key->site] = $key->value;
				}

		        return $getvisibility;
			break;
			case 'get-allowed-region':
				$allowedRegion = [];
				$results = $db->find('`test-server`.`pt_regions_visibility`');
				
				foreach($results as $key){
        			$allowedRegion[$key->region_id] = unserialize($key->visibility);
   				}

   				return $allowedRegion;
			break;
			case 'ae-create-action':
				$successMsg = array();
				$failedMsg = array();

				$product = self::getProductsAffiliate();
				$productToInsert = Product::prepareProductValues($product);
				
				if(isset($product['message']))
					$failedMsg[] = Array( "message" => 'No Available creation for this offer', 'url' => $product['url'], 'merchant' => $product['merchant']);
					
				if(!empty($productToInsert)){
					foreach($productToInsert as $website => $productArray){
						$product = new Product($website);
						$bool = $product->insertMultiple($productArray , 'multidimensional');

						$count = count($productArray);
						$inc = 0;
						if($bool){
							foreach($productArray as $data){
								// $getSite = self::getSite($website);
								// $getId = $db->find('`'.$getSite.'`.`pt_products`',[
								// 	'column' => ['id'],
								// 	'conditions' => ['merchant = ?', 'normalised_name = ?', 'edition = ?', 'region = ?'],
								// 	'bind' => [$data['merchant'], $data['normalised_name'], $data['edition'], $data['region']]
								// ]);
								$productId = (int)$db->lastID(); //initial last id
								if($count > 1 && $inc != 0) //it means we are not now in the first loop
									$productId += $inc;
								
								$successMsg[$website][] = [
									'merchant' => $data['merchant'],
									'buy_url' => $data['buy_url'],
									'buy_url_raw' => $data['buy_url_raw'],
									'region' => $data['region'],
									'edition' => $data['edition'],
									'normalised_name' => $data['normalised_name'],
									//'id' => $getId[0]->id,
									'id' => $productId,
									'site' => $website,
									'user' => Users::currentUser()->id
								];
								$inc++;
							}
						} else {
							$failedMsg[$website][] = "Something went wrong for inserting in $website !!";
						}
					}
				}

				return array('success' => $successMsg, 'failed' => $failedMsg);
			break;
			case 'ae-edit-action':
				$product = new Product($getInput->get('source'));
				$productValues = $product->prepareInsertProduct($_POST['productformData']);
				$bool = $product->update($getInput->get('productId'), $productValues);

				$successArr = array();
				if($bool == true){
					$successArr[] = [
						'id' => $getInput->get('productId'),
						'site' => $getInput->get('source'),
						'user' => Users::currentUser()->id
					];
				}
				return $successArr;
			break;
			case 'ae-check-existing-data':
                $site = self::getSite($getInput->get('getSite'));
                $getMerchant = $getInput->get('getMerchant');
                $getEdition = $getInput->get('getEdition');
                $getRegion = $getInput->get('getRegion');
                $getnname = $getInput->get('getNname');

                $sql = "SELECT count(*) as getcount FROM `$site`.`pt_products` where 
                    merchant = '".$getInput->get('getMerchant')."' and 
                    edition = '".$getInput->get('getEdition')."' and 
                    region = '".$getInput->get('getRegion')."' and 
                    normalised_name = ".$getInput->get('getNname')."";

                return $db->query($sql)->results()[0]->getcount;
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
				if(empty($getProductByNormalisedName)) return [];

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
			case "insert-to-notifiction":
				$notiFields = [
					'productID' => $getInput->get('getID'),
					'action' => $getInput->get('getWhat'),
					'site' => $getInput->get('getSite'),
					'employeeID' => $getInput->get('getEmployee')
				];

				// $insertToLogs old name
				$insertToNotification = $db->insert('`aks`.`tblNotification`', $notiFields);
			break;
		} //END OF SWITCH CASE
	
	}//END OF FUNCTION AJAXDATA

	public static function getProductsAffiliate(){
		
		$productPerWebsite = [];
		$product = $_POST['productformData'];
		$options  = (!empty($_POST['productOptions'])) ? $_POST['productOptions'] : [] ;
				
		$merchants = [];
		foreach($options as $option){ $merchants[$option['merchantID']] = $option['merchantID']; }
		$queryMerchants = implode(',', $merchants);
		if(empty($queryMerchants))
			return Array( "message" => 'No Available creation for this offer', 'url' => $product['ae-url-input'], 'merchant' => $product['ae-merchant-input']);

		AffiliateUtility::getAffiliate($queryMerchants);
		foreach($options as $option){
			switch($option['site']){
				case 'AKS':
				case 'CDD':
				case 'BREX':
					$affiliate = new AffiliateUtility($option);
					$preparedData = $affiliate->getPreparedAffiliate();
					$product = self::updateArrayProduct($product, $preparedData, $option);
					//$productPerWebsite[$option['site']][] = $preparedData;
					$productPerWebsite[$option['site']][] = $product;
				break;
			}
		}
		return $productPerWebsite;
	}
	
	public static function getSite($site){
		switch ($site) {
			case 'AKS':
			case 'aks':
				$site = 'test-server';
			break;
			case 'CDD':
			case 'cdd':
				$site = 'compareprices';
			break;
			case 'BREX':
			case 'brexitgbp':
				$site = 'brexitgbp';
			break;
			default: $site = false;
			break;
		}
		return $site;
	}

	public static function productMessage(){

	}

	public static function updateArrayProduct($baseProduct, $preparedFromAffiliate ,$option){
		$baseProduct['ae-region-input'] = $option['region'];
		$baseProduct['ae-edition-input'] = $option['edition'];
		$baseProduct['ae-merchant-input'] = $preparedFromAffiliate['merchant'];
		$baseProduct['ae-url-input'] = $preparedFromAffiliate['buy_url'];
		$baseProduct['ae-url_raw-input'] = $preparedFromAffiliate['buy_url_raw'];
		return $baseProduct;
	}


}
