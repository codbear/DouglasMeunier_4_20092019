<?php

namespace Codbear\Alaska\Controllers;

use Codbear\Alaska\Interfaces\ControllerInterface;

class HomeController implements ControllerInterface {

	public function execute($params, $datas) {
		$title = 'Un billet pour l\'Alaska';
		require_once('../App/Views/home.php');
	}
}
