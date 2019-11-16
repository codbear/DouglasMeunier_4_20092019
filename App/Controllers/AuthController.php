<?php

namespace Codbear\Alaska\Controllers;

use Exception;
use Codbear\Alaska\Services\Session;
use Codbear\Alaska\Models\Tables\UsersTable;
use Codbear\Alaska\Interfaces\ControllerInterface;

class AuthController extends Controller implements ControllerInterface
{
    public function execute($params, $datas)
    {
        try {
            if (isset($params['action'])) {
                switch ($params['action']) {
                    case 'register':
                        if (empty($datas['username'])) {
                            throw new Exception("Veuillez saisir un nom d'utilisateur");
                        }
                        if (empty($datas['password'])) {
                            throw new Exception('Veuillez saisir un mot de passe');
                        }
                        if (empty($datas['email'])) {
                            throw new Exception('Veuillez saisir un e-mail');
                        }
                        $this->register($datas['username'], $datas['password'], $datas['email']);
                        break;

                    case 'login':
                        if (empty($datas['username'])) {
                            throw new Exception("Veuillez saisir un nom d'utilisateur");
                        }
                        if (empty($datas['password'])) {
                            throw new Exception('Veuillez saisir un mot de passe');
                        }
                        $this->login($datas['username'], $datas['password']);
                        break;

                    case 'logout':
                        $this->logout();
                        break;

                    default:
                        return $this->notFound();
                        break;
                }
                header('Location: /');
            } else {
                return $this->notFound();
            }
        } catch (Exception $e) {
            Session::setFlashbag($e->getMessage(), 'error');
            header('Location: /');
        }
    }

    private function login(string $username, string $password)
    {
        try {
            $user = UsersTable::get($username);
            if ($user === false) {
                throw new Exception("Le nom d'utilisateur ou le mot de passe que vous avez saisis est incorrecte");
            }
            if (!password_verify($password, $user->password)) {
                throw new Exception("Le nom d'utilisateur ou le mot de passe que vous avez saisis est incorrecte");
            }
            Session::set('user', [
                'username' => $user->username,
                'role' => (int) $user->role_id,
                'id' => (int) $user->id
            ]);
        } catch (Exception $e) {
            Session::setFlashbag($e->getMessage(), 'error');
        }
    }

    private function register(string $username, string $password, string $email)
    {
        try {
            if (UsersTable::checkUsernameInDatabase($username)) {
                throw new Exception("Le pseudo que vous avez saisi n'est pas valide");
            }
            if (UsersTable::checkEmailInDatabase($email)) {
                throw new Exception("L'adresse e-mail que vous avez saisie n'est pas valide");
            }
            if (UsersTable::register($username, password_hash($password, PASSWORD_DEFAULT), $email)) {
                $this->login($username, $password);
            } else {
                throw new Exception("Une erreur innatendue est survenue, merci de réessayer plus tard");
            }
        } catch (Exception $e) {
            Session::setFlashbag($e->getMessage(), 'error');
        }
    }

    private function logout()
    {
        Session::unset('user');
        Session::set('user', ['role' => UsersTable::ROLE_ANONYMOUS]);
    }
}
