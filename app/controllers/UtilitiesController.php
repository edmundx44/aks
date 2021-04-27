<?php
namespace App\Controllers;
use Core\Controller;
use Core\H;
use App\Models\Users;
use App\Models\Ajax;
use Core\DB;

class UtilitiesController extends Controller {

	public function __construct($controller, $action) {
		parent::__construct($controller, $action);
	}

	public function realDoubleAction() {
		self::ajaxFunction();
		$this->view->pageTitle = 'Real Double Links';
		$this->view->render('admin/utilities/real-double-links');
	}

	public function affiliateCheckAction() {
		self::ajaxFunction();
		$this->view->pageTitle = 'Affiliate Link Check';
		$this->view->render('admin/utilities/affiliate-link-check');
	}

	public function suspiciousDoubleAction() {
		self::ajaxFunction();
		$this->view->pageTitle = 'Suspicious Double Links';
		$this->view->render('admin/utilities/suspicious-double-links');
	}

	public function metacriticsDoubleAction() {
		self::ajaxFunction();
		$this->view->pageTitle = 'Metacritics Double Links';
		$this->view->render('admin/utilities/metacritics-double-links');
	}

	public function ajaxFunction(){
		if($this->request->isPost('action')){
			$ajaxResult = Ajax::ajaxData($this->request->get('action'));
			$this->jsonResponse($ajaxResult);
		}
	}

	public static function get_good_sqlv2($merchant_id,$affiliate_link,$dbName){
		$sql="SELECT buy_url,id,normalised_name
			FROM  `$dbName`.`pt_products` 
			WHERE  `merchant` = '$merchant_id'
			AND  `buy_url` NOT LIKE CONVERT( _utf8 '%$affiliate_link%'
			USING latin1 ) 
			AND normalised_name != 50 AND  `buy_url` != ''
			LIMIT 0 , 100";
		return $sql;
	}
	public static function loop_result($affiliate,$results,$getUrl,$getWhat,$urlCheck){
		foreach ($results as $key ) {
			if ($key->$affiliate != '') {
				$sqlarr[] = '('.$urlCheck.' != "" AND normalised_name != 50 AND merchant = '.$key->merchant_id.' AND '.$getUrl.' '.$getWhat.' LIKE "%'.htmlspecialchars_decode($key->$affiliate).'%")';
			}
		}
		return $sqlarr;
	}
	
}