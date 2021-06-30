<?php
namespace App\Models;
use Core\DB;

class Product{


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