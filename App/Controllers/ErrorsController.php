<?php

namespace Codbear\Alaska\Controllers;

use Codbear\Alaska\Interfaces\ControllerInterface;

class ErrorsController implements ControllerInterface {

	public static function error403() {
		$title = 'Erreur 403';
        header("HTTP/1.0 403 Forbidden");
		require_once('../App/Views/Errors/error403.php');
	}

	public static function error404() {
		$title = 'Erreur 404';
        header("HTTP/1.0 404 Not Found");
		require_once('../App/Views/Errors/error404.php');
	}

	public function execute($params, $datas) {
		$this->error404();
	}
}
