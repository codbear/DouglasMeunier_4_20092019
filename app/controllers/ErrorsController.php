<?php

require_once('../app/interfaces/ControllerInterface.php');

class ErrorsController implements ControllerInterface {

	public function execute($params, $datas) {
		$title = 'Erreur 404';
        header("HTTP/1.0 404 Not Found");
		require_once('../app/views/404.php');
	}
}
