<?php

namespace Codbear\Alaska\Controllers;

require_once('../App/Interfaces/ControllerInterface.php');

class HomeController implements ControllerInterface {

	public function execute($params, $datas) {
		$title = 'Un billet pour l\'Alaska';
		require_once('../App/Views/home.php');
	}
}
