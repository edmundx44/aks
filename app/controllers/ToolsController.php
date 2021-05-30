<?php
namespace App\Controllers;
use Core\Controller;
use Core\H;
use Core\DB;
use Core\Input;
use App\Models\Ajax;
use App\Models\Users;

class ToolsController extends Controller {

	public function __construct($controller, $action) {
		parent::__construct($controller, $action);
		$this->load_model('Utilities'); //load utilities class in model then use $this->UtilitiesModel
	}

	public function merchantEditionAction($queryParameters = false) {
		self::ajaxFunction();
		$utilities = $this->UtilitiesModel;

		//vd($queryParameters);
		$this->view->dataEdition =  $utilities->dataEdition();
		$this->view->dataMerchant = $utilities->dataMerchant();
			
		$this->view->pageTitle = 'Merchant edition price check';
		$this->view->render('admin/tools/merchant-edition');
	}

	public function priceCheckAction($queryParameters = false) {

		self::ajaxFunction();
		$this->view->pageTitle = 'Price Check Tool';
		$this->view->render('admin/tools/price-check');
	}

	public function rhynAction($queryParameters = false) {
		self::ajaxFunction();
		$this->view->pageTitle = 'Rhyn Tool';
		$this->view->render('admin/tools/rhyn');
	}

	public function romainAction($queryParameters = false) {
		self::ajaxFunction();
		$this->view->pageTitle = 'Romain Tool';
		$this->view->render('admin/tools/romain');
	}

	public function criticsErrorAction($queryParameters = false){
		self::ajaxFunction();
		$this->view->pageTitle = 'Metacritics Error Ratings';
		$this->view->render('admin/tools/critics-error');
	}

	public function feedDataAction($queryParameters = false){
		self::ajaxFunction();

		$this->view->pageTitle = 'Feed Data';
		$this->view->render('admin/tools/feed-data');
	}

	public function ratingListAction($queryParameters = false){
		self::ajaxFunction();

		$this->view->pageTitle = 'Rating List';
		$this->view->render('admin/tools/rating-list');
	}

	public function ajaxFunction(){
		if($this->request->isPost('action')){
			$ajaxResult = Ajax::ajaxData($this->request->get('action'));
			$this->jsonResponse($ajaxResult);
		}
	}

}

