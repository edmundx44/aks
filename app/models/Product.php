<?php
namespace App\Models;
use Core\DB;

class Product{


    
    public static function isMerchantVisible(int $merchant) {
        static $merchantVisibility = [];
        
        if(in_array($merchant,$merchantVisibility))
            return true;
        return false;
    }

    public static function isRegionVisible(int $region)  {

        static $regionVisibility;

        if(!isset($regionVisibility)){
            $regionVisibility = [1,2,3,4,5];
            return $regionVisibility;
        }
        return "Have data now no need to set";
    }
    
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

    private static function getTable($site){
		switch ($site) {
			case 'aks':
			case 'AKS': 
                $site = '`test-server`';
			break;
			case 'cdd':
			case 'CDD': 
                $site = '`compareprices`';
			break;
			case 'brexitgbp':
			case 'BREXITGBP': 
                $site = '`brexitgbp`';
			break;
		}
		return $site;
	}
}