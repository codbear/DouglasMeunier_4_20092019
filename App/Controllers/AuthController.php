<?php

namespace Codbear\Alaska\Controllers;

use Exception;
use Codbear\Alaska\Services\Session;
use Codbear\Alaska\Models\UsersModel;
use Codbear\Alaska\Interfaces\ControllerInterface;
use Codbear\Alaska\Services\Security;
use stdClass;

class AuthController extends Controller implements ControllerInterface
{
    private $userForm = null;
    private $user = null;

    public function execute($params, $datas)
    {
        if (isset($params['action'])) {
            $this->userForm = new stdClass();

            switch ($params['action']) {
                case 'register':
                    $this->setUsername($datas['username']);
                    $this->setEmail($datas['email']);
                    $this->setPassword($datas['password']);
                    $this->register();
                    break;

                case 'login':
                    $this->setUsername($datas['username'], false);
                    $this->setPassword($datas['password']);
                    $this->login();
                    break;

                case 'logout':
                    $this->logout();
                    break;

                default:
                    return $this->notFound();
                    break;
            }

            header('Location: /');
            exit;
        } else {
            return $this->notFound();
        }
    }

    private function login()
    {
        $this->user = UsersModel::get($this->userForm->username);

        if (!$this->user || !password_verify($this->userForm->password, $this->user->password)) {
            throw new Exception('Le mot de passe que vous avez saisis est incorrect');
        }

        Session::setFlashbag('Bienvenue ' . $this->user->username);
        Session::set('user', [
            'username' => $this->user->username,
            'role' => (int) $this->user->role,
            'id' => (int) $this->user->id
        ]);
    }

    private function register()
    {
        $registered = UsersModel::register($this->userForm->username, $this->userForm->hashedPassword, $this->userForm->email);

        if ($registered) {
            $this->login();
        } else {
            throw new Exception('Une erreur innatendue est survenue, merci de réessayer plus tard');
        }
    }

    private function logout()
    {
        Session::unset('user');
        Session::set('user', ['role' => UsersModel::ROLE_ANONYMOUS]);
    }

    private function setUsername(string $username, bool $checkAvailability = true): void
    {
        if (empty($username)) {
            throw new Exception('Veuillez saisir un pseudo');
        }

        if ($checkAvailability && UsersModel::checkUsernameInDatabase($username)) {
            throw new Exception('Le pseudo que vous avez saisi n\'est pas valide');
        }

        $this->userForm->username = Security::protectString($username);
    }

    private function setEmail(string $email): void
    {
        if (empty($email)) {
            throw new Exception('Veuillez saisir une adresse e-mail');
        }

        $email = filter_var($email, FILTER_SANITIZE_EMAIL);

        if (UsersModel::checkEmailInDatabase($email) || filter_var($email, FILTER_VALIDATE_EMAIL) === false) {
            throw new Exception('L\'adresse e-mail que vous avez saisie n\'est pas valide');
        }

        $this->userForm->email = Security::protectString($email);
    }

    private function setPassword(string $password): void
    {
        if (empty($password)) {
            throw new Exception('Veuillez saisir un mot de passe');
        }

        $this->userForm->password = $password;
        $this->userForm->hashedPassword = password_hash($password, PASSWORD_DEFAULT);
    }
}
