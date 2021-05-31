<?php
namespace App\Controllers;
use Core\Controller;

class linksController extends Controller {

	public function __construct($controller, $action) {
		parent::__construct($controller, $action);
	}

	public function affiliateCheckAction($queryParameters = false) {
		$this->view->pageTitle = 'Affiliate Link Check';
		$this->view->render('admin/links/affiliate-link-check');
	}

	public function doubleLinksAction($queryParameters = false) {
		$this->view->pageTitle = 'Double Links';
		$this->view->render('admin/links/double-links');
	}
}