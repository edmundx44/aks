<?php
namespace App\Models;
use App\Controllers\ReportsController;
use \DOMDocument;
use \DOMXpath;

class Merchant {
	public static function merchantData($site, $url){
		preg_match('/^.*\/\/([.w]+\.+|)(.*)\.com/', $url, $outputMerchant);
		$getMerchant = $outputMerchant[2];
		switch ($site) {
			case 'AKS':
				switch ($getMerchant) {
					case 'g2a':
						$array = array();
						$getG2aPlus = '/plus/i';
						preg_match($getG2aPlus, $url, $outputG2aPlus);
						$link = (isset($outputG2aPlus[0]))? 'https://product-feeder.g2a.com/v1/provider/ALLKEYSHOP/feed/6034d0a0362ef9ea99b001f6' : 'https://product-feeder.g2a.com/v1/provider/ALLKEYSHOP/feed/6034cd0d362ef9ea99b001f3';
						$xml = simplexml_load_file($link) or die("Cant open the file");
						preg_match('/^.+\-(i\d+)\?.+/', $url, $outputG2aId);

						foreach($xml->children() as $game) {
							if($outputG2aId[1] == preg_replace('/^.+\-(i\d+)\?.+/','${1}',$game->URL)) {
								$array[] = array(
									'price' => "$game->Price", 
									'stock' => "$game->Availability",
									'url' 	=> "$game->URL"
								);
								break;
							}
						}
						return $array;
					break;
				}
			break;
			case 'CDD':
				switch ($getMerchant) {
					case 'g2a':
						$array = array();
						$getG2aPlus = '/plus/i';
						preg_match($getG2aPlus, $url, $outputG2aPlus);
						$link = (isset($outputG2aPlus[0]))? 'https://product-feeder.g2a.com/v1/provider/ALLKEYSHOP/feed/6034d182362ef9ea99b001f7' : 'https://product-feeder.g2a.com/v1/provider/ALLKEYSHOP/feed/6034ce07362ef9ea99b001f4';
						$xml = simplexml_load_file($link) or die("Cant open the file");
						preg_match('/^.+\-(i\d+)\?.+/', $url, $outputG2aId);

						foreach($xml->children() as $game) {
							if($outputG2aId[1] == preg_replace('/^.+\-(i\d+)\?.+/','${1}',$game->URL)) {
								$array[] = array(
									'price' => "$game->Price", 
									'stock' => "$game->Availability",
									'url' 	=> "$game->URL"
								);
								break;
							}
						}
						return $array;
					break;
				}
			break;
			case 'BREX':
				
			break;
		}
	}
	public static function merchantSiteXpath($url){
		preg_match('/^.*\/\/([.w]+\.+|)(.*)\.com/', $url, $outputMerchant);
		$getMerchant = $outputMerchant[2];
		switch ($getMerchant) {
			case 'g2a':
				$getG2aPlus = '/plus/i';
				preg_match($getG2aPlus, $url, $outputG2aPlus);
				if(isset($outputG2aPlus[0])){

				}else{
					$xpathLowerPrice = '//*[@class="offers-list"]/div/div/div[1]/div/div[2]/div/div/div/span[1]';		
					$xpathMainPrice = '//*[@class="product-info"]/div/div[4]/div/div/div/div[2]/div[2]/div[1]/span[1]';		
					$xpathStock = '//*[@class="product-info"]/div/div[4]/div/span';	
				}
			break;
		}

		$scrapedData = array(); 
		$getUrl = $url;
		$getUrlSub = $url;

		while (true) {
		    $html = self::getUrlContent($getUrl);
		    $getUrl = $html['redirect_url'];
		    if($html['http_code'] == 200){
		        $getUrl = $html['url'];

		        $getCont = self::getUrlContent($getUrl);
		        $doc = new DOMDocument;
		        $doc->preserveWhiteSpace = false;
		        @$doc->loadHTML($getCont['content']);
		        $xpath = new DOMXpath($doc);

		        $getPriceQuery = $xpath->query($xpathLowerPrice);
				$getStockQuery = $xpath->query($xpathStock);

				if($getPriceQuery->length == 1) $getPrice = $getPriceQuery->item(0)->nodeValue;
				else {
					$getMainPriceQuery = $xpath->query($xpathMainPrice);
					$getPrice = ($getMainPriceQuery->length == 1)? $getMainPriceQuery->item(0)->nodeValue : '';
				}

				$scrapedData = array(
					'sitePrice' => $getPrice,
					'siteStock' => ($getStockQuery->length == 1)? $getStockQuery->item(0)->nodeValue : ''
				);

				$getUrl = $getUrlSub;

				return $scrapedData;
		        break;
		    }
		}
	}
	public static function getUrlContent($url) {
		$options = array(
			CURLOPT_RETURNTRANSFER => true,     // return web page
			CURLOPT_HEADER         => false,    // don't return headers
			CURLOPT_FOLLOWLOCATION => true,     // follow redirects
			CURLOPT_ENCODING       => "",       // handle all encodings
			CURLOPT_USERAGENT      => "Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/89.0.4389.114 Safari/537.36",
			CURLOPT_AUTOREFERER    => true,     // set referer on redirect
			CURLOPT_CONNECTTIMEOUT => 60,      // timeout on connect
			CURLOPT_TIMEOUT        => 60,      // timeout on response
			CURLOPT_MAXREDIRS      => 0,       // stop after 10 redirects
			CURLOPT_HTTPHEADER     => [ 'Accept-Encoding: gzip, deflate, br', 'Accept-Language: fr,en-US;q=0.9,en;q=0.8,fr-FR;q=0.7' ],
		);

		$ch      = curl_init( $url );
		curl_setopt_array( $ch, $options );
		$content = curl_exec( $ch );
		$err     = curl_errno( $ch );
		$errmsg  = curl_error( $ch );
		$header  = curl_getinfo( $ch );
		curl_close( $ch );

		$header['errno']   = $err;
		$header['errmsg']  = $errmsg;
		$header['content'] = $content;
		return $header;
	}
}
