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

					case 'hrkgame':
						 $array = array();
						 $url = preg_replace('/^.+\/product(.+)\/?/', '${1}' ,$url);
						 $url = preg_replace('/\/$/','',$url);
						if(isset($url)){
							$feed = 'https://www.hrkgame.com/hotdeals/xml-feed/?key=F546F-DFRWE-DS3FV&cur=eur&ver='.time();
							$xml = simplexml_load_file($feed) or die("Cant open the file");
							$ns = $xml->getNamespaces(true);
							foreach($xml->channel->children() as $prod){
								$link = preg_replace('/^.+\/product(.+)\/?/','${1}',$prod->link);
								$link = preg_replace('/\/$/','',$link);

								$price = str_replace('€','',$prod->children($ns['g'])->price);
								$stock = $prod->children($ns['g'])->availability;
								if($url == $link){
									$array[] = array(
										'price' => "$price", 
										'stock' => "$stock",
										'url' 	=> "$prod->link"
									);
									break;
								}
							}
						}else{ return []; }
						return $array;
					break;

					case 'mmoga':
						$array = array();
						$url = preg_replace('/^(.*)\?ref=615.*/', '${1}', $url);
						if(isset($url)){
							$resource = curl_init();
							$link = 'https://www.mmoga.com/sitemap.html?xml=1&n=mm_affiliate&k=xf2KtbyuUbYTamkBA8TR&no_download=1&key_only=1&currency=EUR';
							curl_setopt($resource, CURLOPT_USERAGENT,'Mozilla/5.0 (X11; Ubuntu; Linux i686; rv:24.0) Gecko/20100101 Firefox/24.0');
							curl_setopt($resource, CURLOPT_URL, $link);
							curl_setopt($resource, CURLOPT_HEADER, FALSE);
							curl_setopt($resource, CURLOPT_FOLLOWLOCATION, TRUE);
							curl_setopt($resource, CURLOPT_RETURNTRANSFER, true);
							$data = curl_exec($resource);
							curl_close($resource);
							$prod = simplexml_load_string($data)or die("Error: Cannot create object");
							foreach($prod->product as $keys){
								$link = str_replace('?ref=615','',$keys->products_url);
								$price = $keys->products_price;
								if($url == "$link"){
									$array[] = array(
										'price' => "$price",
										'stock' => 1 ,
										'url' => "$link"
									);
									break;
								}
							}
						}else{ return []; }
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

			default: return [];
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

				$userAgent = "Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/89.0.4389.114 Safari/537.36";
				$httpHeader = [ 'Accept-Encoding: gzip, deflate, br', 'Accept-Language: fr,en-US;q=0.9,en;q=0.8,fr-FR;q=0.7' ];

				if(isset($outputG2aPlus[0])){

				}else{
					$xpathMainPrice = '//*[@class="product-info"]/div/div[4]/div/div/div/div[2]/div[2]/div[1]/span[1]';	
					$xpathLowerPrice = '//*[@class="offers-list"]/div/div/div[1]/div/div[2]/div/div/div/span[1]';
					$xpathStock = '//*[@id="app"]/div/div[2]/div/article/header/div/div[4]/div/div/div/div[2]/div[3]/button/span';	
				}
			break;
			case 'hrkgame':
				$userAgent = "";
				$httpHeader = [ 'Accept-Language: fr,en-US;q=0.9,en;q=0.8,fr-FR;q=0.7' ];

				$xpathMainPrice = "";
				$xpathLowerPrice = '//div[@class="huge bw_button_wrapper"]//div[@class="price_list"]//div[@class="price"]';
				$xpathStock = "//div[contains(@class, 'product_container')]/div/div/div[3]/div[5]/div";

			break;

			case 'mmoga':
				$httpHeader = [];
				$userAgent = "Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/89.0.4389.114 Safari/537.36";

				$xpathMainPrice = "";
				$xpathLowerPrice = '//div[@class="produktdetail"]//div[@class="proMoney"]//p[@class="now"]';
				$xpathStock = '//div[@class="produktdetail"]//div[@class="proInfo"]//tr[2]//td';

			break;

			default: return $scrapedData = ['sitePrice' => 'Something went wrong !!', 'siteStock' => "Something went wrong !!"];
			break;

		}
		//$x("//input[@id='radio486'] [0] / @onclick ")
		$scrapedData = array(); 
		$getUrl = $url;
		$getUrlSub = $url;
		$x = 0;
		while ($x < 10) {
		    $html = self::getUrlContent($getUrl ,$userAgent ,$httpHeader);
		    $getUrl = $html['redirect_url'];
		    if($html['http_code'] == 200){
		        $getUrl = $html['url'];
		        //$getCont = self::getUrlContent($getUrl ,$userAgent ,$httpHeader);
		        $getCont = $html;
		        $doc = new DOMDocument;
		        $doc->preserveWhiteSpace = false;
		        @$doc->loadHTML($getCont['content']);
		        $xpath = new DOMXpath($doc);

		        $getMainPrice = (!empty($xpathMainPrice))? $xpath->query($xpathMainPrice) : '';
                $get1stPriceQuery = $xpath->query($xpathLowerPrice);
                $getStockQuery = $xpath->query($xpathStock);
            
                $node1stPrice = ($get1stPriceQuery->length == 1)? $get1stPriceQuery->item(0)->nodeValue : 0 ;
                $nodeMainPrice = (!empty($getMainPrice) and $getMainPrice->length == 1)? $getMainPrice->item(0)->nodeValue : 0 ;
    
                $getPrice = ($node1stPrice <= $nodeMainPrice)? $node1stPrice : $nodeMainPrice;

				switch($getMerchant){
					case 'mmoga': $getStock = (trim($getStockQuery->item(0)->nodeValue) == 'available')? 'In stock' : "Out of stock";
					break;	

					default: $getStock = ($getStockQuery->length == 1)? 'In stock' : "Out of stock";
					break;
				}


				$scrapedData = array(
					'sitePrice' => $getPrice,
					'siteStock' => $getStock 
				);

				$getUrl = $getUrlSub;
				return $scrapedData;
		        break;
		    }
			$x++;
		}
		if($x == 10 )
			return $scrapedData = ['sitePrice' => 'Something went wrong !!', 'siteStock' => "Something went wrong !!"];
	}
	public static function getUrlContent($url, $userAgent, $httpHeader) {
		$options = array(
			CURLOPT_PROXY          => 'http://bot:hidemyass@aksdeveu1.allkeyshop.com:8181',
			CURLOPT_RETURNTRANSFER => true,     // return web page
			CURLOPT_HEADER         => false,    // don't return headers
			CURLOPT_FOLLOWLOCATION => true,     // follow redirects
			CURLOPT_ENCODING       => "",       // handle all encodings
			CURLOPT_USERAGENT      => $userAgent,
			CURLOPT_AUTOREFERER    => true,     // set referer on redirect
			CURLOPT_CONNECTTIMEOUT => 60,      // timeout on connect
			CURLOPT_TIMEOUT        => 60,      // timeout on response
			CURLOPT_MAXREDIRS      => 9,       // stop after 10 redirects
			CURLOPT_HTTPHEADER     => $httpHeader,
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

	public static function xPathCompare($price , $price1){
		$price = str_replace(',', '.' ,$price);
		$price1 = str_replace(',', '.' ,$price1);

		if(isset($price) && isset($price1))
			return $price = ((float)$price < (float)$price1) ? (float)$price : (float)$price1;
		else 
			return 'Something went wrong !!';
	}

}
