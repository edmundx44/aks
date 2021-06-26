<?php
namespace App\Models;
use Core\DB;

class AffiliateUtility{
    
    public static function isAffiliateUrl(string $url, int $merchantId, string $website): bool
    {   
        $locale = self::getLocale($website);
        $options = self::getAffiliate($merchantId);
        $value = $options[$locale]['check_regex'];
        $regex = ( $value != null ) ? $value : null;
        if (!$regex)
            return false;
        return preg_match($regex, $url);
    }

    public static function getAffiliate(int $merchantId)
    {
        static $affiliate; //caching

        if(!isset($affiliate)){
            $db = DB::getInstance();
            $sql = "SELECT * FROM `test-server`.`affiliate_urls` WHERE merchant_id = ?";
            $affiliate[$merchantId] = $db->query($sql, [ $merchantId ])->results();
        }

        return $affiliate[$merchantId];
    }

    public static function addAffiliation(string $url, int $merchantId, string $website): string
    {
        $locale = self::getLocale($website);
        return $option = self::getAffiliate($merchantId);
    }

    public static function getLocale($website): string 
    {
        switch ($website) {
            case 'aks': 
                $locale = 'en_EU';
            break;
            case 'cdd': 
                $locale = 'en_US';
            break;
            case 'brexitgbp': 
                $locale = 'en_GB';
            break;
        }
        return $locale;
    }
}