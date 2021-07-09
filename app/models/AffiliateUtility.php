<?php
namespace App\Models;
use Core\DB;

class AffiliateUtility {
    
    private int $merchant;
    private string $initial_url;
    private string $buy_url;
    private string $buy_url_raw = '';

    public string $locale;
    public static $affiliateData; //caching

    public function __construct(array $options){
        $options = self::urlFeedRaw($options);
        $this->initial_url = $options['url'];
        $this->buy_url = $options['url'];
        $this->merchant = $options['merchantID'];
        $this->locale = self::getLocale($options['site']);
    }

    public function getPreparedAffiliate() {
        if($this->isAffiliateUrlExists()){
            $affiliate = true;
            $this->removedAffiliate($affiliate); // <-- if this function have parameter then it means link has affiliate 
            $this->addReplacementRawToUrl();
            return $this->returnData();
        }
        $this->removedAffiliate();
        $this->addReplacementRawToUrl();
        $this->addAffiliateToUrl();
        return $this->returnData();
    }

    /**
     * Return Final Buy Url and Buy Url Raw
     * @return array
     */ 
    private function returnData() {
        return $returnOption = [ 'buy_url' => $this->buy_url, 'buy_url_raw' => $this->buy_url_raw, 'merchant' => $this->merchant ];
    }

    /**
     * Check if the input url has affiliate
     * @return bool
     */ 
    private function isAffiliateUrlExists() {
        $options = static::$affiliateData;
        $regex = (isset($options[$this->locale][$this->merchant]['check_regex'])) ? $options[$this->locale][$this->merchant]['check_regex'] : null;
        return (!$regex) ? false : preg_match($regex, $this->buy_url);
    }

    /**
     * Add Affiliate to the Buy_URL
     * From affiliate_url table 
     * $options['search_regex'] = ~(?<url>.+)~
     * $options['replacement_pattern'] = {url}?ref=allkeyshop
     * 
     * Expected url as Link https://2game.com/en/grand-theft-auto-v
     * preg match the Link using $options['search_regex'] if true expected result have key [url] in $matches container and the value is full match of the Link
     * 
     * Replace {url} strin in $options['replacement_pattern'] with the $matches[url] value
     * 
     * Final Result 
     * https://2game.com/en/grand-theft-auto-v?ref=allkeyshop
     * @return object
     */ 
    private function addAffiliateToUrl() {
        $options = static::$affiliateData[$this->locale][$this->merchant] ?? null;
        if (!isset($options['search_regex'], $options['replacement_pattern']) || empty($options['search_regex']) AND empty($options['replacement_pattern']))
            return $this;
        
        if(preg_match($options['search_regex'], $this->buy_url, $matches)){
            $buy_url = $options['replacement_pattern']; //sample {url}?tracking=allkeyshop
            if(array_key_exists('url',$matches))
                $this->buy_url = str_replace('{url}', $matches['url'], $buy_url);
            if(array_key_exists('path',$matches))
                $this->buy_url = str_replace('{path}', $matches['path'], $buy_url);
        }
        return $this;
    }

    /**
     * Add ReplaceMentRaw to the BUY_URL_RAW
     * From affiliate_url table 
     * $options['search_regex'] = ~(?<url>.+)~
     * $options['replacement_pattern_raw'] = {url}?currency=EUR
     * 
     * Expected url as Link https://www.mmoga.com/Steam-Games/The-Ascent.html
     * preg match the Link using $options['search_regex'] if true expected result have key [url] in $matches container and the value is full match of the Link
     * 
     * Replace {url} string in $options['replacement_pattern_raw'] with the $matches[url] value
     * 
     * Final Result 
     * https://www.mmoga.com/Steam-Games/The-Ascent.html?currency=EUR
     * @return object
     */ 
    private function addReplacementRawToUrl(){
        $options = static::$affiliateData[$this->locale][$this->merchant] ?? null;
        $options['search_regex'] = (empty($options['search_regex']) || !isset($options['search_regex'])) ? '/empty in db/' : $options['search_regex'] ;

        if (!isset($options['replacement_pattern_raw']) AND empty($options['replacement_pattern_raw']))
            return $this;

        if(preg_match($options['search_regex'], $this->buy_url_raw, $matches)){
            $buy_url_raw = $options['replacement_pattern_raw'];
            if(array_key_exists('url',$matches)){
                $matches['url'] = $this->alter_match_result_case($matches['url']);
                $this->buy_url_raw = str_replace('{url}', $matches['url'], $buy_url_raw);
            }   
            if(array_key_exists('path',$matches)){
                $matches['path'] = $this->alter_match_result_case($matches['path']);
                $this->buy_url_raw = str_replace('{path}', $matches['path'], $buy_url_raw);
            }
        } else {
            $this->special_case_for_adding_buy_url_raw($options);
        }

        return $this;
    }
    /**
     * Remove Affiliate
     * From affiliate_url table Sample Merchant: Cdkeys 9
     * $options['check_regex'] = ~mw_aref=8023ef0aa94165947417b567beee956d~
     * $options['replacement_pattern'] = {url}?mw_aref=8023ef0aa94165947417b567beee956d
     * 
     * Url as Link https://www.cdkeys.com/xbox-live/games/sea-of-thieves-xbox-one?mw_aref=8023ef0aa94165947417b567beee956d
     * Preg match the Link using $options['check_regex'] if true 
     * 
     * Replace {url} string in $options['replacement_pattern'] to empty string ''
     *
     * Will be now $options['replacement_pattern'] = ?mw_aref=8023ef0aa94165947417b567beee956d used to replace the Link to empty string ''
     * 
     * Final Result 
     * https://www.cdkeys.com/xbox-live/games/sea-of-thieves-xbox-one
     * @return object
     */ 
    private function removedAffiliate($affiliate = false) {
        $options = static::$affiliateData;
        if(!isset($options))
            return $this;
        //To remove affiliate for each LOCALES affiliate
        foreach ($options as $locale) {
            $check_regex = $locale[$this->merchant]['check_regex'] ?? null;
            $replacement_pattern = $locale[$this->merchant]['replacement_pattern'] ?? null;
            if (!isset($replacement_pattern)) {
                $this->buy_url_raw = $this->initial_url;
                continue;
            }
            if(preg_match($check_regex, $this->buy_url)){
                $pattern = preg_replace('/{url}|{path}/', '', $replacement_pattern);
                $rawLink = str_replace($pattern,'', $this->buy_url);
                $this->buy_url = ($affiliate) ? $this->initial_url : $rawLink;
                $this->buy_url_raw = ($affiliate) ? $rawLink : $this->initial_url;
                break;
            }
        }
        if(empty($this->buy_url_raw) && $affiliate == false)
            $this->buy_url_raw = $this->initial_url;
        return $this;
    }
    /**
     * Run First this function in order to populate the $affiliateData static variable;
     * 
     * Feed it with merchantId argument value 12,212,213 
     * @param string $merchantId
     * @return array
     */
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
                        'replacement_pattern_raw' => $value->replacement_pattern_raw,
                        'check_regex' => $value->check_regex
                    ];
            }
            static::$affiliateData = $temp;
        }
        return (isset(static::$affiliateData)) ? static::$affiliateData : null;
    }

    /**
     * Alter $options['search_regex'] Value
     * @param array $options
     * @return void
     */
    public function special_case_for_adding_buy_url_raw($options){
        switch ($this->merchant) {
            case 270:
            case 2700:
                $options['search_regex'] = ($this->merchant == 2700) ? '~(?<url>.+)~' : '~&dl=(?<url>.+)~';
                if(preg_match($options['search_regex'], $this->buy_url_raw, $matches)){
                    $buy_url_raw = $options['replacement_pattern_raw']; //{path} used in db for 270|2700
                    if(array_key_exists('url',$matches))
                        $this->buy_url_raw = str_replace('{path}', $matches['url'], $buy_url_raw);
                }
            case 228:
                $options['search_regex'] = '~&dl=(?<url>.+)~'; 
                if(preg_match($options['search_regex'], $this->buy_url_raw, $matches)){
                    $buy_url_raw = $options['replacement_pattern_raw'];
                    if(array_key_exists('url',$matches))
                        $this->buy_url_raw = str_replace('{url}', $matches['url'], $buy_url_raw);
                }
            default:
            break;
        }
    }

    public function special_case_for_removing_affiliate(){
        echo "Test";
    }

    /**
     * Alter $matches results
     * @param string $matches
     * @return string
     */
    public function alter_match_result_case($matches){
        switch ($this->merchant) {
            case 62: case 100: case 101: case 620: case 621:
                $matches = str_replace('?ref=147', '', $matches);
            break;
            default:
            break;
        }
        return $matches;
    }

    /**
     * get Locale value using $website sample 'AKS' return locale 'en_EU
     * @param string $website
     * @return string
     */
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
            case 9: case 38: case 47: case 49: case 490:   
    			$product['url'] = preg_replace('/\?.*/', '', $product['url']);
    		break;
    		case 61: 
                $product['url'] = str_replace('/en-gb/', '/en/', $product['url']);
    		break;
            case 63: //Remove first the affiliate if exist
                $product['url'] = preg_replace('/^.*\?url=/', '', $product['url']);
            break;
            case 228: //Empty replacement_pattern in affiliate url table
                $product['url'] = preg_replace('/&ws=$/', '', $product['url']); //Remove First 
                $product['url'] = str_replace("%2F", "/", $product['url']);     //Check First 
                $product['url'] = preg_replace('/&dl=\/?en\//', '&dl=/en/', $product['url']); //Check if has en/ 
                if(!preg_match('/&dl=\/?en\//', $product['url'], $matches))
                    $product['url'] = preg_replace('/&dl=/','&dl=/en/', $product['url']); //Not reachable if TEUE
                $product['url'] = preg_replace('@https://lt45.net/c/.+dl=@', 'https://lt45.net/c/?si=13482&li=1594900&wi=288216&ws=&dl=', $product['url']);
            break;
    		case 270: //Empty search regex 270  use this ~allyouplay.com/(?<path>.+?)/?$~ AND replacement pattern use this https://lt45.net/c/?si=13256&li=1594938&wi=288216&ws=&dl={path} 
            case 2700:
                $product['url'] = preg_replace('/&ws=$/', '', $product['url']);
                if(!preg_match('/&dl=en\//', $product['url']))
                    $product['url'] = str_replace('&dl=','&dl=en/', $product['url']);
                if(!preg_match('/\/en\//',$product['url']))
                    $product['url'] = str_replace('.com/','.com/en/', $product['url']);

                if($product['merchantID'] == 270){ //IF input url has allyouplay.com
                    if(preg_match('~allyouplay.com/(?<path>.+?)/?$~', $product['url'], $matches))
                        $product['url'] = 'https://lt45.net/c/?si=13482&li=1594900&wi=288216&ws=&dl='.$matches['path'];
                }
    		break;
    	}
    	return $product;
    }
}