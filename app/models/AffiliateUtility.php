<?php
namespace App\Models;
use Core\DB;

class AffiliateUtility {
    
    private int $merchant;
    private string $initial_url;
    private string $buy_url;
    private string $buy_url_raw;

    public string $locale;
    public static $locales = ['en_EU', 'en_US', 'en_GB'];
    public static $affiliateData; //caching

    public function __construct(array $options){

        $options = self::urlFeedRaw($options);

        $this->initial_url = $options['url'];
        $this->buy_url = $options['url'];
        $this->buy_url_raw = ''; //empty for now comment line 70
        $this->merchant = $options['merchantID'];
        $this->locale = self::getLocale($options['site']);

        //$this->buy_url_raw = $options['url'];
    }

    public function getPreparedAffiliate() {

        if($this->isAffiliateUrlExists()){
            $this->removedAffiliate(); //put this to remove the affiliate from the buy_url to use for buy_url_raw for now buy_url_raw is set to ''
            return $this->returnData($this->initial_url);
        }
        $this->removedAffiliate();
        $this->addAffiliateToUrl();
        return $this->returnData();
    }

    private function isAffiliateUrlExists() {
        $options = static::$affiliateData;
        $regex = (isset($options[$this->locale][$this->merchant]['check_regex'])) ? $options[$this->locale][$this->merchant]['check_regex'] : null;
        return (!$regex) ? false : preg_match($regex, $this->buy_url);
    }

    private function addAffiliateToUrl() {
        $options = static::$affiliateData[$this->locale][$this->merchant] ?? null;
        if (!isset($options['search_regex'], $options['replacement_pattern']) || empty($options['search_regex']) AND empty($options['replacement_pattern']))
            return $this;
        
        preg_match($options['search_regex'], $this->buy_url, $matches); //capture link with this pattern  ~(?<url>.+)~
        $this->buy_url = $options['replacement_pattern']; //sample {url}?tracking=allkeyshop

        if(array_key_exists('url',$matches))
            $this->buy_url = str_replace('{url}', $matches['url'], $this->buy_url);
        return $this;
    }

    private function removedAffiliate() {
        $options = static::$affiliateData;
        if(!isset($options))
            return $this;

        //To remove affiliate for each LOCALES affiliate
        foreach(static::$locales as $locale){
            $check_regex = $options[$locale][$this->merchant]['check_regex'] ?? null;
            $replacement_pattern = $options[$locale][$this->merchant]['replacement_pattern'] ?? null;

            if (!isset($replacement_pattern, $check_regex))
                continue;

            if(preg_match($check_regex, $this->buy_url)){
                $pattern = str_replace('{url}','', $replacement_pattern);
                $pattern = str_replace('{path}','', $replacement_pattern); //some merchant used path
                $this->buy_url = str_replace($pattern,'', $this->buy_url);
                //$this->buy_url_raw = str_replace($pattern,'', $this->buy_url_raw); //line 70
                break;
            }
    
        }
        return $this;
    }

    private function returnData($initial_url = false) {
        return (!$initial_url) ? $returnOption = [ 'buy_url' => $this->buy_url, 'buy_url_raw' => $this->buy_url_raw, 'merchant' => $this->merchant ] : $returnOption = [ 'buy_url' => $initial_url, 'buy_url_raw' => $this->buy_url_raw, 'merchant' => $this->merchant ];
    }

    public static function getAffiliate(string $merchantId) {

        if(!isset(static::$affiliateData)){
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
            static::$affiliateData = $temp;
        }
        return (isset(static::$affiliateData)) ? static::$affiliateData : null;
    }

    public static function getLocale($website): string {
        switch ($website) {
            case 'AKS': 
                $locale = 'en_EU';
            break;
            case 'CDD': 
                $locale = 'en_US';
            break;
            case 'BREX': 
                $locale = 'en_GB';
            break;
        }
        return $locale;
    }

    //cleaning url from the feed
    //Special case for the url feed that have conflict for the affiliate in db;
    public static function urlFeedRaw(array $product) {
        $option = static::$affiliateData;

    	switch($product['merchantID']){
            case 400:  //dont have 400 in affiliate url table 
                $product['url'] = preg_replace('/\?.*/', '', $product['url']);
                $product['url'] .= '?ref=615&currency=GBP';
                break;
            case 2232: //dont have 2223 in affiliate url table
                $product['url'] = preg_replace('/\?.*/', '', $product['url']);
                $product['url'] .= '?affiliate=allkeyshop';
                break;
            case 168:  //dont have 168 in affiliate url table
                $product['url'] = preg_replace('/\?.*/', '', $product['url']);
                $product['url'] .= '?ars=cdd';
            break;
            case 66: //Empty replacement_pattern & check_regex ... replacement_pattern = {url}?tag=wwwcheapdig06-20, check_regex =  ~tag=wwwcheapdig06-20~ where Locale = en_US
                $product['url'] = preg_replace('/\?.*/', '', $product['url']);
                $product['url'] .= '?tag=wwwcheapdig06-20';
                break;
            case 9:
            case 47:
            case 49:
            case 490:   
    			$product['url'] = preg_replace('/\?.*/', '', $product['url']);
    		    break;
            case 228: //Empty replacement_pattern in affiliate url table
                $product['url'] = str_replace('&ws=', '', $product['url']);
                $product['url'] = preg_replace('@/en/|en%2F@','', $product['url']);

                $product['url'] = preg_replace('@https://lt45.net/c/.+dl=@', 'https://lt45.net/c/?si=13482&li=1594900&wi=288216&ws=&dl=/en/', $product['url']);
                break;
    		case 270: //for 270 merchant
            case 2700://for 2700 merchant
    			$product['url'] = str_replace('&ws=', '', $product['url']);
                $product['url'] = str_replace('en/','', $product['url']); //if url input have en/ remove it first

                //have 270 but empty search_regex and replacement_pattern in affiliate url table
                //if theres some changes in affiliate url change it here and also for txtfile/getAvailable.txt
            	$product['url'] = preg_replace('@https://lt45.net/c/\?si=13256&li=1594938.*288216.*&dl=?@', 'https://lt45.net/c/?si=13256&li=1594938&wi=288216&ws=&dl=en/', $product['url']);
                
                if($product['merchantID'] == 2700){
                    //$product['url'] = preg_replace('@https://lt45.net/c/\?si=13256&li=1581736.*288216.*&dl=?@', 'https://lt45.net/c/?si=13256&li=1581736&wi=288216&ws=&dl=en/', $product['url']); //for 2700 merchant
                    $replacement = str_replace('{path}', '', $option['en_GB'][2700]['replacement_pattern']); //en-EU & en-GB data is the same in db
                    $product['url'] = preg_replace('@https://lt45.net/c/\?si=13256&li=1581736.*288216.*&dl=?@', $replacement."en/", $product['url']);
                }
    		    break;
    		case 61: $product['url'] = str_replace('/en-gb/', '/en/', $product['url']);
    		    break;

            // case 9: $product['url'] = str_replace('?__currency=eur', '', $product['url']);
    		// break;
            // case 47: $product['url'] = str_replace('?nosalesbooster=currency=EUR&roff=1&noff=1', '', $product['url']);
    		// break;
    	}
    	return $product;
    }
}