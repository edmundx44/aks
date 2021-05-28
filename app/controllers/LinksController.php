<?php
namespace App\Controllers;
use Core\Controller;
use Core\H;
use Core\DB;
use Core\Input;
use App\Models\Ajax;
use App\Models\Users;

class linksController extends Controller {

	public function __construct($controller, $action) {
		parent::__construct($controller, $action);
	}

	public function realDoubleAction() {
		self::ajaxFunction();

		if(isset($queryParameters[0])){
			$this->view->render('restricted/badUrl');
			return false;
		}

		$this->view->pageTitle = 'Real Double Links';
		$this->view->render('admin/links/real-double-links');
	}

	public function affiliateCheckAction($queryParameters = false) {
		self::ajaxFunction();

		// $validGetPost = [ 'url_check' => [ 'buy_url', 'buy_url_raw' ] ];
		// $granted = true;
		// if(!empty($this->request->get())){
		// 	foreach ($this->request->get() as $key => $val) { 
		// 		if(!array_key_exists($key,$validGetPost)) 
		// 			$granted = false; //if field is not exists in validGetPost
		// 		else{
		// 			if(!in_array($val, $validGetPost[$key]))
		// 				$granted = false; //if field is not exists in validGetPost value
		// 		}
		// 	}
		// }
		// if(!$granted){
		// 	$this->view->render('restricted/badUrl');
		// 	return false;
		// }

		// $this->view->getPost = (isset($_GET['url_check'])) ? $this->request->get('url_check') : 'buy_url';
		// $this->view->text = ($this->view->getPost == 'buy_url_raw') ? 'Buy Url Raw' : 'Buy Url';

		$this->view->pageTitle = 'Affiliate Link Check';
		$this->view->render('admin/links/affiliate-link-check');
	}

	public function doubleLinksAction($queryParameters = false) {
		self::ajaxFunction();
		$this->view->pageTitle = 'Double Links';
		$this->view->render('admin/links/double-links');
	}

	// public function suspiciousDoubleAction($queryParameters = false) {
	// 	self::ajaxFunction();
	// 	$this->view->pageTitle = 'Suspicious Double Links';
	// 	$this->view->render('admin/links/suspicious-double-links');
	// }

	// public function metacriticsDoubleAction($queryParameters = false) {
	// 	self::ajaxFunction();
	// 	$this->view->pageTitle = 'Metacritics Double Links';
	// 	$this->view->render('admin/links/metacritics-double-links');
	// }

	// public function metacriticsErrorRatingAction($queryParameters = false){
	// 	self::ajaxFunction();
	// 	$this->view->pageTitle = 'Metacritics Error Ratings';
	// 	$this->view->render('admin/links/metacritics-error-rating');

	// }

	public function ajaxFunction(){
		if($this->request->isPost('action')){
			$ajaxResult = Ajax::ajaxData($this->request->get('action'));
			$this->jsonResponse($ajaxResult);
		}
	}

	
}