<?php

namespace Codbear\Alaska\Controllers;

use Exception;
use Codbear\Alaska\Session;
use Codbear\Alaska\Models\UserModel;
use Codbear\Alaska\Interfaces\ControllerInterface;

class LoginController implements ControllerInterface
{

    private function registerUser($datas)
    {
        $user = new UserModel();

        try {
            if (empty($datas['username'])) {
                throw new Exception("Veuillez saisir un pseudo.", 1);
            }
            if ($this->usernameExistInDatabase($datas['username'])) {
                throw new Exception("Le nom d'utilisateur que vous avez saisi n'est pas valide", 1);
            }
            $user->setUsername($datas['username']);

            if (empty($datas['email'])) {
                throw new Exception("Veuillez saisir une adresse mail.", 1);
            }
            if ((!filter_var($datas['email'], FILTER_VALIDATE_EMAIL)) || (UserModel::checkEmailInDatabase($datas['email']))) {
                throw new Exception("L adresse mail que vous avez saisie n'est pas valide.", 1);
            }
            $user->setEmail($datas['email']);

            if (empty($datas['password'])) {
                throw new Exception("Veuillez saisir un mot de passe.", 1);
            }
            $registration = $user->register(password_hash($datas['password'], PASSWORD_DEFAULT));

            if ($registration === false) {
                throw new Exception("Une erreur inatendue est survenue. Merci de réessayer ultérieurement", 1);
            } else {
                Session::setUser($user);
                Session::setFlash(('Votre compte a été créé. Bienvenue ' . $_SESSION['username'] . ' !'), 'success');
                header('Location: /');
            }
        } catch (Exception $e) {
            Session::setFlash($e->getMessage(), 'error');
            header('Location: /?view=login');
        }
    }

    private function loginUser($datas)
    {
        $user = new UserModel();

        try {
            if (empty($datas['username'])) {
                throw new Exception("Veuillez saisir un pseudo.", 1);
            }
            if (!$this->usernameExistInDatabase($datas['username'])) {
                throw new Exception("Le nom d'utilisateur que vous avez saisi n'est pas valide", 1);
            }
            $user->setUsername($datas['username']);

            if (empty($datas['password'])) {
                throw new Exception("Veuillez saisir un mot de passe.", 1);
            }
            if (!password_verify($datas['password'], $user->getPasswordFromDatabase())) {
                throw new Exception("Le mot de passe que vous avez saisi est incorrect", 1);
            }

            $user->hydrateUser();

            Session::setUser($user);
            Session::setFlash(('Heureux de vous revoir ' . $_SESSION['username'] . ' !'), 'success');
            header('Location: /');
        } catch (Exception $e) {
            Session::setFlash($e->getMessage(), 'error');
            header('Location: /?view=login');
        }
    }

    private function usernameExistInDatabase($username)
    {
        $usernameExist = UserModel::checkUsernameInDatabase($username);
        if ($usernameExist) {
            return true;
        } else {
            return false;
        }
    }

    private function emailExistInDatabase($email)
    {
        return UserModel::checkEmailInDatabase($email);
    }

    public function execute($params, $datas)
    {
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
                    Session::unsetUser();
                    header('Location: /');
                    break;

                default:
                    ErrorsController::error404();
                    die;
                    break;
            }
        } else {
            require_once('../App/Views/login.php');
        }
    }
}
