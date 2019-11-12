<?php

namespace Codbear\Alaska\Controllers;

use Codbear\Alaska\Interfaces\ControllerInterface;

class ErrorsController extends Controller implements ControllerInterface {

	public static function error401() {
		header("HTTP/1.0 401 Unauthorized");
		return $this->renderer->render('errors.error401', ['title' => 'Erreur 401']);
	}

	public static function error403() {
		header("HTTP/1.0 403 Forbidden");
		return $this->renderer->render('errors.error403', ['title' => 'Erreur 403']);
	}

	public static function error404() {
		header("HTTP/1.0 404 Not Found");
		return $this->renderer->render('errors.error404', ['title' => 'Erreur 404']);
	}

	public function execute($params, $datas) {
		self::error404();
	}
}
