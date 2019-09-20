<?php

require_once('../app/interfaces/ControllerInterface.php');
require_once('../app/models/LoginModel.php');

class LoginController implements ControllerInterface {

	private function registerUser($datas) {
		$username = $datas['username'];
		$email = $datas['email'];
		$password = password_hash($datas['password'], PASSWORD_DEFAULT);
		$role = 2;
		$login = new LoginModel();
		$register = $login->registerUser($username, $email, $password, $role);
	}

	public function execute($params, $datas) {
		$title = 'Un billet pour l\'Alaska - Connexion / Inscription';

		if (isset($params['action'])) {
			switch ($params['action']) {
				case 'register':
					$this->registerUser($datas);
					break;

				default:
					// code...
					break;
			}
		} else {
			require_once('../app/views/login.php');
		}
	}
}
