<?php

require_once('../app/interfaces/ControllerInterface.php');
require_once('../app/models/UserModel.php');

class LoginController implements ControllerInterface {

	private function registerUser($datas) {
        $user = new UserModel();
		$username = $datas['username'];
        if (isset($datas['username'])) {
            $user->setUsername($datas['username']);
        } else {
            throw new \Exception("Error username", 1);
        }
        if (filter_var($datas['email'], FILTER_VALIDATE_EMAIL)) {
            $user->setEmail($datas['email']);
        } else {
            throw new \Exception("Wrong Email", 1);
        }
        if (isset($datas['password'])) {
            $user->setPassword(password_hash($datas['password'], PASSWORD_DEFAULT));
        } else {
            throw new \Exception("Error password", 1);
        }
		$registered = $user->register();
		if ($registered === false) {
			throw new \Exception("Error creating user", 1);

		} else {
			$_SESSION['isConnected'] = true;
			header('Location: index.php');
		}
	}

    private function loginUser($datas) {
        if (isset($datas['username']) && isset($datas['password'])) {
            $user = new UserModel();
            $user->setUsername($datas['username']);
            $password = $user->getPasswordFromDatabase();
            if ($password === password_hash($datas['password'], PASSWORD_DEFAULT)) {
                $_SESSION['isConnected'] = true;
                header('Location: index.php');
            } else {
                throw new \Exception("Error connecting user", 1);
            }
        } else {
            throw new \Exception("missing username or password", 1);
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
