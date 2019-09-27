<?php

namespace Codbear\Alaska\Controllers;

require_once('../App/Interfaces/ControllerInterface.php');

class ErrorsController implements ControllerInterface {

	public function execute($params, $datas) {
		$title = 'Erreur 404';
        header("HTTP/1.0 404 Not Found");
		require_once('../App/Views/404.php');
	}
}
