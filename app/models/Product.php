<?php
namespace App\Models;
use Core\DB;
use Core\Model;

class Product extends Model{

    //positional
    public static $aks_fields = [
            'id', 'merchant', 'filename', 'name', 'description', 'description-usa', 'description-ru', 'description-fr', 'description-de', 'description-es', 'description-it', 'description-pt', 'description-nl',
            'image_url', 'buy_url', 'buy_url_raw', 'price', 'category', 'brand', 'rating', 'reviews', 'search_name', 'keyword', 'normalised_name', 'original_name', 'voucher_code', 'dupe_hash',
            'edition', 'region', 'dispo', 'prix_gamescards_id', 'buy_url_bis', 'buy_url_tier', 'buy_url_4', 'prix_date_start', 'prix_date_end', 'prix_prix_categ_id', 'prix_devise', 'releasedate',
            'releaseyear', 'metacritic_score', 'metacritic_count', 'metacritic_critic_score', 'metacritic_critic_count', 'metacritic_user_score', 'metacritic_user_count', 'flag', 'last_pass',
            'last_modified', 'is_console', 'created_by', 'created_time', 'normal_bot_update_time', 'instant_bot_update_time', 'manual_updated_time'
    ]; 
    public static $websites = ['AKS', 'CDD', 'BREX'];


    public function __construct($website = 'AKS'){
		$table = self::getTable($website);
        parent::__construct($table);
    }
    
	public function createProductByWebsite($product) {
		$sqlData = [];

		foreach($product as $website => $data){
			if(in_array($website, static::$websites)){
				$getColumn = ($website == 'CDD') ? 'description-eu' : 'description-usa';

				foreach ($data as $key => $value) {
					//IN ORDER
					
					$getDescription = ($website == 'CDD') ? $value["ae-description-usa-or-eu-input"] : $value['ae-description-input'] ;
					$getDescriptionEuUS = ($website == 'CDD') ? $value['ae-description-input'] : $value["ae-description-usa-or-eu-input"] ;
					
					$sqlData[$website][] = [
						'merchant'       => $value["ae-merchant-input"], 
						'filename'       => '', 
						'name'           => '', 
						'description'    => $getDescription, 
						$getColumn       => $getDescriptionEuUS, 
						'description-ru' => '', 
						'description-fr' => $value["ae-description-fr-input"], 
						'description-de' => $value["ae-description-de-input"], 
						'description-es' => $value["ae-description-es-input"], 
						'description-it' => $value["ae-description-it-input"], 
						'description-pt' => $value["ae-description-pt-input"], 
						'description-nl' => $value["ae-description-nl-input"],
						'image_url'      => $value["ae-image-url-input"], 
						'buy_url'        => $value["ae-url-input"], 
						'buy_url_raw'    => $value["ae-url_raw-input"], 
						'price'          => 0, 
						'category'       => $value["ae-category-input"], 
						'brand'          => '', 
						'rating'         => 0, 
						'reviews'        => 0, 
						'search_name'    => $value["ae-search-name-input"], 
						'keyword'        => $value["ae-keyword-input"], 
						'normalised_name'=> $value["ae-gameid-input"], 
						'original_name'  => '', 
						'voucher_code'   => '', 
						'dupe_hash'      => '',
            			'edition'        => $value["ae-edition-input"], 
						'region'         => $value["ae-region-input"], 
						'dispo'          => 0, 
						'prix_gamescards_id' => 0, 
						'buy_url_bis'    =>  '', 
						'buy_url_tier'   =>  '', 
						'buy_url_4'      =>  '',
						'releasedate'    => $value["ae-release-date-input"],
            			'releaseyear'    => $value['ae-release-year-input'], 
						'metacritic_score' => $value["ae-metacritic-score-input"], 
						'metacritic_count' => $value["ae-metacritic-count-input"], 
						'metacritic_critic_score' => $value["ae-metacritic-critic-score-input"], 
						'metacritic_critic_count' => $value["ae-metacritic-critic-count-input"], 
						'metacritic_user_score'   => $value["ae-metacritic-user-score-input"], 
						'metacritic_user_count'   => $value["ae-metacritic-user-count-input"], 
						'flag'           => 0, 
						'is_console'     => $value["is_console"], 
						'created_by'     => ucfirst(Users::currentUser()->fname), 
					];
				}
			}
		}
		return $sqlData;
	}

	public function insertProductByWebsite($productToInsert){
		$successMsg = array();
		$failedMsg = array();

		if(!empty($productToInsert)){
			foreach($productToInsert as $website => $productArray){
				$product = new Self($website);
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
						$productId = (int)$this->_db->lastID(); //initial last id
						if($count > 1 && $inc != 0){ //it means we are not now in the first loop
							$productId += $inc;	
						}	
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
	}

	public function prepareInsertProduct($product){
		$sqlData = [];
		$sqlData = [
			'merchant'       => $product["ae-merchant-input"], 
			'buy_url'        => $product["ae-url-input"], 
			'buy_url_raw'    => $product["ae-url-raw-input"], 
			'category'       => $product["ae-category-input"], 
			'rating'         => $product["ae-ratings-input"],  
			'normalised_name'=> $product["ae-gameid-input"],
			'edition'        => $product["ae-edition-input"], 
			'region'         => $product["ae-region-input"],
			'search_name'    => $product["ae-search-name-input"],
			'buy_url_bis'    => $product["ae-buy-url-bis-input"], 
			'buy_url_tier'   => $product["ae-buy-url-tier-input"], 
			'buy_url_4'      => $product["ae-buy-url-4-input"],
		];
		return $sqlData;
	}

	public function queryTestingInsert($fields = [], $arrayType = 'multidimensional') {
		$fieldsString = '';
		$dataValues = [];
		$table = '`test-server`.`pt_products`'; //static
		foreach($fields as $field => $values) {
			$fieldsString = '`'.implode("`,`", array_keys($values)). '`';
			$valueString[] = "(".rtrim(str_repeat("?,", count($values)), ',').")";
			switch ($arrayType) {
				case 'multidimensional':
					$dataValues[] = $values;
					break;
				default: //one-dimensional
					foreach ($values as $data) { $dataValues[] = $data; }
					break;
			}
		}
		$sql = "INSERT INTO {$table} ({$fieldsString}) VALUES ".implode(",", $valueString)."";
		return $sql;
	}

	public function tableCheck(){
		return $this->_table;
    }

	public static function is_console($game_id){
		$db = DB::getInstance();

		$sql ="SELECT `description` FROM `test-server`.`pt_products` WHERE `normalised_name` = ? AND `merchant` = '424242' LIMIT 1";
		$result = $db->query($sql, [ $game_id ])->results()[0];
		$consoles_name = ['ps4','-3ds-','playstation','nintendo','xbox','wii-u'];
		if(!empty($result)){
			foreach ($consoles_name as $console_name) {
				if (strpos($result->description, $console_name) !== FALSE) { 
					return $is_console = 1;
				}
			}
		}
		return $is_console = 0;
	}

    private static function getTable($website){
		switch ($website) {
			case 'AKS':
                $website = '`test-server`.`pt_products`';
			break;
			case 'CDD': 
                $website = '`compareprices`.`pt_products`';
			break;
			case 'BREX': 
                $website = '`brexitgbp`.`pt_products`';
			break;
		}
		return $website;
	}

}