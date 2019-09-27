<?php

namespace Codbear\Alaska\Controllers;

use Codbear\Alaska\Session;
use Codbear\Alaska\Models\UserModel;
use Codbear\Alaska\Interfaces\ControllerInterface;

class LoginController implements ControllerInterface {

	private function registerUser($datas) {
        $user = new UserModel();

        if  ((!isset($datas['username'])) || ($datas['username'] === '')) {
            Session::setFlash('Veuillez saisir un pseudo.', 'error');
            header('Location: /?view=login');
            return;
        }
        if ($this->usernameExistInDatabase($datas['username'])) {
            Session::setFlash('Le nom d\'utilisateur que vous avez choisi est déjà utilisé.', 'error');
            header('Location: /?view=login');
            return;
        }
        $user->setUsername($datas['username']);

        if ((!isset($datas['email'])) || ($datas['email'] === '')) {
            Session::setFlash('Veuillez saisir une adresse mail.', 'error');
            header('Location: /?view=login');
            return;
        }
        if (!filter_var($datas['email'], FILTER_VALIDATE_EMAIL)) {
            Session::setFlash('L\'Email que vous avez saisie n\'est pas valide.', 'error');
            header('Location: /?view=login');
            return;
        }
        if ($this->emailExistInDatabase($datas['email'])) {
            Session::setFlash('L\'adresse email que vous avez saisie est déjà utilisée.', 'error');
            header('Location: /?view=login');
            return;
        }
        $user->setEmail($datas['email']);

        if ((!isset($datas['password'])) || ($datas['password'] === '')) {
            Session::setFlash('Veuillez saisir un mot de passe.', 'error');
            header('Location: /?view=login');
            return;
        }
        $registration = $user->register(password_hash($datas['password'], PASSWORD_DEFAULT));
        
		if ($registration === false) {
			Session::setFlash('Une erreur inatendue est survenue. Merci de réessayer ultérieurement', 'error');
            header('Location: /?view=login');
            return;
		} else {
            Session::setSession($user);
            Session::setFlash(('Votre compte a été créé. Bienvenue ' . $_SESSION['username'] . ' !'), 'success');
			header('Location: /');
		}
	}

    private function loginUser($datas) {
        $user = new UserModel();

        if  ((!isset($datas['username'])) || ($datas['username'] === '')) {
            Session::setFlash('Veuillez saisir un pseudo.', 'error');
            header('Location: /?view=login');
            return;
        }
        if (!$this->usernameExistInDatabase($datas['username'])) {
            Session::setFlash('Le pseudo que vous avez saisis n\'existe pas.', 'error');
            header('Location: /?view=login');
            return;
        }
        $user->setUsername($datas['username']);

        if ((!isset($datas['password'])) || ($datas['password'] === '')) {
            Session::setFlash('Veuillez saisir un mot de passe.', 'error');
            header('Location: /?view=login');
            return;
        }
        if (!password_verify($datas['password'], $user->getPasswordFromDatabase())) {
            Session::setFlash('Le mot de passe que vous avez saisi est incorrect', 'error');
            header('Location: /?view=login');
            return;
        }

        $user->hydrateUser();
        
        Session::setSession($user);
        Session::setFlash(('Heureux de vous revoir ' . $_SESSION['username'] . ' !'), 'success');
        header('Location: /');
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
