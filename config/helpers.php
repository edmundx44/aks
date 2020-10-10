<?php

	error_reporting(E_ALL);
	ini_set('display_errors', 1);
	ini_set('log_errors', 1);
	ini_set('error_log', ROOT . DS .'tmp' . DS . 'errors.log');

	function vd($data){
		echo '<pre>';
			var_dump($data);
		echo '</pre>';
    	die();
	}