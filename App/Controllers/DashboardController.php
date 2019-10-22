<?php

namespace Codbear\Alaska\Controllers;

use Codbear\Alaska\Interfaces\ControllerInterface;

class DashboardController implements ControllerInterface {

    public function execute($params, $datas) {
		$title = 'Dashboard';
		require_once('../App/Views/chapters.php');
	}

}