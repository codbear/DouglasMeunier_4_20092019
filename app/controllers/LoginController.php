<?php

require_once('../app/interfaces/ControllerInterface.php');
require_once('../app/models/UserModel.php');

class LoginController implements ControllerInterface {

	private function registerUser($datas) {
        $user = new UserModel();
        if ($this->usernameExistInDatabase($datas['username'])) {
            throw new Exception("Username already exist", 1);
        }
        if (isset($datas['username'])) {
            $user->setUsername($datas['username']);
        } else {
            throw new \Exception("Error username", 1);
        }
        if (filter_var($datas['email'], FILTER_VALIDATE_EMAIL)) {
            if ($this->emailExistInDatabase($datas['email'], $user)) {
                throw new Exception("Email already exist", 1);
            }
            $user->setEmail($datas['email']);
        } else {
            throw new \Exception("Wrong Email", 1);
        }
        if (isset($datas['password'])) {
            $user->setPassword(password_hash($datas['password'], PASSWORD_DEFAULT));
        } else {
            throw new \Exception("Error password", 1);
        }
        $user->setRole(UserModel::ROLE_DEFAULT);
		$registered = $user->register();
		if ($registered === false) {
			throw new \Exception("Error creating user", 1);

		} else {
			$this->setSession($user);
			header('Location: index.php');
		}
	}

    private function loginUser($datas) {
        if (isset($datas['username']) && isset($datas['password'])) {
            $user = new UserModel();
            if ($this->usernameExistInDatabase($datas['username'])) {
                $user->setUsername($datas['username']);
                if (password_verify($datas['password'], $user->getPasswordFromDatabase())) {
                    $user->hydrateUser();
                    $this->setSession($user);
                    header('Location: index.php');
                } else {
                    throw new \Exception("Wrong Password", 1);
                }  
            } else {
                throw new Exception("Username not found", 1);
                
            }
        } else {
            throw new \Exception("missing username or password", 1);
        }
    }

    private function usernameExistInDatabase($username) {
        $usernameExist = UserModel::checkUsernameInDatabase($username);
        if ($usernameExist) {
            return true;
        } else {
            return false;
        }
    }

    private function emailExistInDatabase($email) {
        $emailExist = UserModel::checkEmailInDatabase($email);
        if ($emailExist) {
            return true;
        } else {
            return false;
        }
    }

    private function setSession($user) {
        $_SESSION['username'] = $user->getUsername();
        $_SESSION['role'] = $user->getRole();
    }

    private function destroySession() {
        unset($_SESSION['username']);
        $_SESSION['role'] = UserModel::ROLE_ANONYMOUS;
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
					$this->destroySession();
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
