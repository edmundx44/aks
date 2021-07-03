<?php
namespace App\Models;
use Core\DB;

class Product{

    //positional
    public static $aks_fields = [
            'id', 'merchant', 'filename', 'name', 'description', 'description-usa', 'description-ru', 'description-fr', 'description-de', 'description-es', 'description-it', 'description-pt', 'description-nl',
            'image_url', 'buy_url', 'buy_url_raw', 'price', 'category', 'brand', 'rating', 'reviews', 'search_name', 'keyword', 'normalised_name', 'original_name', 'voucher_code', 'dupe_hash',
            'edition', 'region', 'dispo', 'prix_gamescards_id', 'buy_url_bis', 'buy_url_tier', 'buy_url_4', 'prix_date_start', 'prix_date_end', 'prix_prix_categ_id', 'prix_devise', 'releasedate',
            'releaseyear', 'metacritic_score', 'metacritic_count', 'metacritic_critic_score', 'metacritic_critic_count', 'metacritic_user_score', 'metacritic_user_count', 'flag', 'last_pass',
            'last_modified', 'is_console', 'created_by', 'created_time', 'normal_bot_update_time', 'instant_bot_update_time', 'manual_updated_time'
    ]; 

    public static $websites = ['AKS', 'CDD', 'BREX'];

    public static function isProductAlreadyCreated(array $product, string $website) : bool
    {
        $db = DB::getInstance();
        $params = [ $product['buy_url'], $product['merchant'], $product['region'], $product['edition'] ];
        $sql = "SELECT `buy_url`,`merchant`,`region`,`edition` 
                FROM `pt_products` 
                WHERE `buy_url` = ? AND `merchant`  = ? AND `region` = ? AND `edition` = ? ";
        $results = $db->query( $sql, $params )->count();
        return (!$results) ? false : true ;
    }

    public function generateTest($merchants,$website,$product) {
        $sql = "SELECT `id`,`merchant`,`buy_url`, `region`, `edition`, `normalised_name` FROM `test-server`.`pt_products` 
                WHERE merchant IN (12,212)
                AND `region` = '2'
                AND `edition` = '1'
                AND `normalised_name` = '281'
                OR `buy_url` = 'https://2game.com/en/grand-theft-auto-v?ref=allkeyshop'
                OR `buy_url` = 'https://2game.com/en-gb/grand-theft-auto-v?ref=allkeyshop'
                LIMIT 25";

        foreach(static::$websites as $website){
           if(array_key_exists($website, $product)){

           }
        }

        
    }

    private static function getTable($website){
		switch ($website) {
			case 'AKS':
                $website = '`test-server`';
			break;
			case 'CDD': 
                $website = '`compareprices`';
			break;
			case 'BREX': 
                $website = '`brexitgbp`';
			break;
		}
		return $website;
	}
}