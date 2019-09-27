<?php

namespace Codbear\Alaska\Controllers;

use Codbear\Alaska\Session;
use Codbear\Alaska\Models\UserModel;
use Codbear\Alaska\Interfaces\ControllerInterface;

class LoginController implements ControllerInterface {

	private function registerUser($datas) {
        $user = new UserModel();

        if ($this->usernameExistInDatabase($datas['username'])) {
            Session::setFlash('Le nom d\'utilisateur que vous avez choisi est déjà utilisé.', 'error');
            header('Location: /?view=login');
            return;
        }

        if (filter_var($datas['email'], FILTER_VALIDATE_EMAIL)) {
            if ($this->emailExistInDatabase($datas['email'], $user)) {
                Session::setFlash('L\'Email que vous avez choisi est déjà utilisée.', 'error');
                return;
            }
            $user->setEmail($datas['email']);
        }

        if (isset($datas['username'])) {
            $user->setUsername($datas['username']);
        } else {
            throw new \Exception("Error username", 1);
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
            Session::setSession($user);
            Session::setFlash(('Votre compte a été créé. Bienvenue ' . $_SESSION['username'] . ' !'), 'success');
			header('Location: /');
		}
	}

    private function loginUser($datas) {
        if (isset($datas['username']) && isset($datas['password'])) {
            $user = new UserModel();
            if ($this->usernameExistInDatabase($datas['username'])) {
                $user->setUsername($datas['username']);
                if (password_verify($datas['password'], $user->getPasswordFromDatabase())) {
                    $user->hydrateUser();
                    Session::setSession($user);
                    Session::setFlash(('Heureux de vous revoir ' . $_SESSION['username'] . ' !'), 'success');
                    header('Location: /');
                } else {
                    Session::setFlash('Le mot de passe que vous avez saisi est incorrect', 'error');
                    header('Location: /?view=login');
                }  
            } else {
                Session::setFlash('Le pseudo que vous avez saisi est incorrect', 'error');
                header('Location: /?view=login');
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
					Session::destroySession();
					header('Location: /');
					break;

				default:
					// code...
					break;
			}
		} else {
			require_once('../App/Views/login.php');
		}
	}
}
