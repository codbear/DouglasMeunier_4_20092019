<?php

require_once('../app/interfaces/ControllerInterface.php');

class HomeController implements ControllerInterface {

	public function execute($params) {
		$title = 'Un billet pour l\'Alaska';
		require_once('../app/views/home.php');
	}
}