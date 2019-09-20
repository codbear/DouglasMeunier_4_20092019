<?php

require_once('../app/interfaces/ControllerInterface.php');

class LoginController implements ControllerInterface {

	public function execute($params) {
		require_once('../app/views/login.php');
	}
}
