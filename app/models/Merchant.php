<?php
namespace App\Models;
use App\Controllers\ReportsController;

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
}
