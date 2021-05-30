<?php
namespace App\Controllers;
use Core\Controller;
use Core\H;
use Core\DB;

class ToolsController extends Controller {

	public function __construct($controller, $action) {
		parent::__construct($controller, $action);
		$this->load_model('Utilities'); //load utilities class in model then use $this->UtilitiesModel
	}

	public function merchantEditionAction($queryParameters = false) {
		$utilities = $this->UtilitiesModel;

		$this->view->dataEdition =  $utilities->dataEdition();
		$this->view->dataMerchant = $utilities->dataMerchant();
			
		$this->view->pageTitle = 'Merchant edition price check';
		$this->view->render('admin/tools/merchant-edition');
	}

	public function priceCheckAction($queryParameters = false) {
		$this->view->pageTitle = 'Price Check Tool';
		$this->view->render('admin/tools/price-check');
	}

	public function rhynAction($queryParameters = false) {
		$this->view->pageTitle = 'Rhyn Tool';
		$this->view->render('admin/tools/rhyn');
	}

	public function romainAction($queryParameters = false) {
		$this->view->pageTitle = 'Romain Tool';
		$this->view->render('admin/tools/romain');
	}

	public function criticsErrorAction($queryParameters = false){
		
		$this->view->pageTitle = 'Metacritics Error Ratings';
		$this->view->render('admin/tools/critics-error');
	}

	public function feedDataAction($queryParameters = false){
		$this->view->pageTitle = 'Feed Data';
		$this->view->render('admin/tools/feed-data');
	}

	public function ratingListAction($queryParameters = false){
		$this->view->pageTitle = 'Rating List';
		$this->view->render('admin/tools/rating-list');
	}
}

