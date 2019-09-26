<?php

require_once('../app/interfaces/ControllerInterface.php');
require_once('../app/models/UserModel.php');

class LoginController implements ControllerInterface {

	private function registerUser($datas) {
		$username = $datas['username'];
		$email = $datas['email'];
		$password = password_hash($datas['password'], PASSWORD_DEFAULT);
		$role = 2;
		$user = new UserModel();
		$registered = $user->register($username, $email, $password, $role);
		if ($registered === false) {
			throw new \Exception("Error creating user", 1);

		} else {
			$_SESSION['isConnected'] = true;
			header('Location: index.php');
		}
	}

    private function loginUser($datas) {
        $user = new UserModel();
        $password = $user->login($datas['username']);
        if ($password === password_hash($datas['password'], PASSWORD_DEFAULT)) {
            $_SESSION['isConnected'] = true;
			header('Location: index.php');
        } else {
            throw new \Exception("Error connecting user", 1);

        }
    }

	public function execute($params, $datas) {
		$title = 'Un billet pour l\'Alaska - Connexion / Inscription';

		if (isset($params['action'])) {
			switch ($params['action']) {
				case 'register':
					$this->registerUser($datas);
					break;

                case 'login':
                    $this->loginUser($datas);
                    break;

				case 'logout':
					unset($_SESSION['isConnected']);
					header('Location: index.php');
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
