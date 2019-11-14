<?php

namespace Codbear\Alaska\Controllers;

use Exception;
use Codbear\Alaska\Models\UserModel;
use Codbear\Alaska\Services\Session;
use Codbear\Alaska\Interfaces\ControllerInterface;

class LoginController extends Controller implements ControllerInterface
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
            if ((!filter_var($datas['email'], FILTER_VALIDATE_EMAIL)) || ($user->checkEmailInDatabase($datas['email']))) {
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
                Session::setFlashbag(('Votre compte a été créé. Bienvenue ' . Session::get('username') . ' !'), 'success');
            }
        } catch (Exception $e) {
            Session::setFlashbag($e->getMessage(), 'error');
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
            Session::setFlashbag(('Heureux de vous revoir ' . Session::get('username') . ' !'), 'success');
        } catch (Exception $e) {
            Session::setFlashbag($e->getMessage(), 'error');
        }
    }

    private function usernameExistInDatabase($username)
    {
        $user = new UserModel();
        $usernameExist = $user->checkUsernameInDatabase($username);
        if ($usernameExist) {
            return true;
        } else {
            return false;
        }
    }

    private function emailExistInDatabase($email)
    {
        $user = new UserModel();
        return $user->checkEmailInDatabase($email);
    }

    public function execute($params, $datas)
    {
        if (isset($params['action'])) {
            switch ($params['action']) {
                case 'register':
                    $this->registerUser($datas);
                    header('Location: /');
                    break;

                case 'login':
                    $this->loginUser($datas);
                    header('Location: /');
                    break;

                case 'logout':
                    Session::unsetUser();
                    header('Location: /');
                    break;

                default:
                    return $this->notFound();
            }
        } else {
            return $this->notFound();
        }
        return $this->renderer->render('home');
    }
}
