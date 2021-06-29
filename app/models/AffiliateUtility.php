<?php
namespace App\Models;
use Core\DB;

class AffiliateUtility{
    
    public static $affiliate; //caching

    public static function getPreparedUrl(string $url, int $merchantId, string $website) {
        
        if(self::isAffiliateUrlExists($url, $merchantId, $website))
            return $url;
        $url = self::removedAffiliate($url, $merchantId);
        return $url = self::addAffiliateToUrl($url, $merchantId, $website);
    }

    public static function isAffiliateUrlExists(string $url, int $merchantId, string $website) {   
        $locale = self::getLocale($website);
        $options = static::$affiliate;
        $value = (isset($options[$locale][$merchantId]['check_regex'])) ? $options[$locale][$merchantId]['check_regex'] : null;
        $regex = ( $value != null ) ? $value : null;
        if (!$regex)
            return false;
        return preg_match($regex, $url);
    }

    public static function getAffiliate(string $merchantId) {

        if(!isset(static::$affiliate)){
            $temp = [];
            $db = DB::getInstance();
            $sql = "SELECT * FROM `test-server`.`affiliate_urls` WHERE merchant_id IN($merchantId)";
            $results = $db->query( $sql, [ $merchantId ])->results();
            foreach($results as $key => $value){
            	if(!array_key_exists($value->locale, $temp))
            		$locale = $value->locale;
            	if(isset($locale))
            		$temp[$locale][$value->merchant_id] = [
            			'id' => $value->id,
            			'merchant_id' => $value->merchant_id,
            			'merchant_name' => $value->merchant_name,
            			'locale' => $value->locale,
            			'search_regex' => $value->search_regex,
            			'replacement_pattern' => $value->replacement_pattern,
            			'check_regex' => $value->check_regex
            		];
            }
            static::$affiliate = $temp;
        }
        return (isset(static::$affiliate)) ? static::$affiliate : null;
    }

    public static function removedAffiliate(string $url, int $merchantId){
        $locales = ['en_EU', 'en_US', 'en_GB'];
        $options = static::$affiliate;
        if(!isset($options))
            return $url;

        foreach($locales as $locale){
            $check_regex = $options[$locale][$merchantId]['check_regex'] ?? null;
            $replacement_pattern = $options[$locale][$merchantId]['replacement_pattern'] ?? null;

            if (!isset($replacement_pattern, $check_regex))
                return $url;

            if(preg_match($check_regex, $url)){
                $pattern = str_replace('{url}','', $replacement_pattern);
                $url = str_replace($pattern,'', $url);
                break;
            }
    
        }
        return $url;
    }

    public static function addAffiliateToUrl(string $url, int $merchantId, string $website) {
        $locale = self::getLocale($website);
        $options = static::$affiliate[$locale][$merchantId] ?? null;

        if (!isset($options['search_regex'], $options['replacement_pattern']) || empty($options['search_regex']) AND empty($options['replacement_pattern']))
            return $url;
    
        preg_match($options['search_regex'], $url, $matches);

        $url = $options['replacement_pattern'];

        if(array_key_exists('url',$matches))
        	$url = str_replace('{url}', $matches['url'], $url);

        return $url;
    }

    public static function getLocale($website): string {	
    	$website = strtolower($website);
        switch ($website) {
            case 'aks': 
                $locale = 'en_EU';
            break;
            case 'cdd': 
                $locale = 'en_US';
            break;
            case 'brex': 
                $locale = 'en_GB';
            break;
        }
        return $locale;
    }

    //cleaning url from the feed
    //Special case for the url feed that have conflict for the affiliate in db;
    public static function urlFeedRaw(array $product) {	
    	switch($product['merchantID']){
    		case 40:
            case 400:
            case 2223:
    			$product['url'] = preg_replace('/\?.*/', '', $product['url']);
                if($product['merchantID'] == 400) //dont have 400 in affiliate url table 
                    $product['url'] .= '?ref=615&currency=GBP';
                if($product['merchantID'] == 2223) //dont have 2223 in affiliate url table 
                    $product['url'] .= '?affiliate=allkeyshop';
    		break;
            case 9:
    			$product['url'] = str_replace('?__currency=eur', '', $product['url']);
    		break;
    		case 47:
    			$product['url'] = str_replace('?nosalesbooster=currency=EUR&roff=1&noff=1', '', $product['url']);
    		break;
    		case 270:
    			$product['url'] = str_replace('&ws=', '', $product['url']);
            	$product['url'] = preg_replace('@https://lt45\.net/c/\?si=13256&li=1594938&wi=288216&pid=.*&dl=?@', 'https://lt45.net/c/?si=13256&li=1594938&wi=288216&ws=&dl=en/', $product['url']);
    		break;
    		case 61:
    			$product['url'] = str_replace('/en-gb/', '/en/', $product['url']);
    		break;
            case 63:
                //$product['url'] = preg_replace('/^.*?\?url=/', '', $product['url']);
            break;
    	}
    	return $product;
    }
//=(\d.*.com)\/
}