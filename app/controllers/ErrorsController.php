<?php

require_once('../app/interfaces/ControllerInterface.php');

class ErrorsController implements ControllerInterface {

	public function execute($params, $datas) {
		$title = 'Erreur 404';
		require_once('../app/views/404.php');
	}
}
