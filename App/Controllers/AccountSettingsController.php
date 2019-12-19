<?php

namespace Codbear\Alaska\Controllers;

use Exception;
use Codbear\Alaska\Services\Session;
use Codbear\Alaska\Controllers\Controller;
use Codbear\Alaska\Models\Tables\UsersTable;
use Codbear\Alaska\Interfaces\ControllerInterface;

class AccountSettingsController extends Controller implements ControllerInterface
{
    private $user = null;

    public function execute(array $params, array $datas)
    {
        $this->user = UsersTable::get(Session::get('user')['username']);
        if (isset($params['action'])) {
            $userId = $params['userId'];
            switch ($params['action']) {
                case 'updateAccount':
                    $this->updateAccount($datas['email']);
                    break;

                case 'updatePassword':
                    $this->updatePassword($datas['actual-password'], $datas['new-password'], $datas['new-password-confirmation']);
                    break;

                case 'deleteAccount':
                    $this->deleteAccount($datas['password']);
                    break;

                default:
                    return $this->notFound();
                    break;
            }
        } else {
            return $this->renderer->render('accountSettings', [
                'title' => "Mon compte | Billet simple pour l'Alaska",
                'user' => $this->user
            ]);
        }
    }

    private function updateAccount(string $email)
    {
        try {
            if ((!filter_var($email, FILTER_VALIDATE_EMAIL)) || (UsersTable::checkEmailInDatabase($email))) {
                throw new Exception("L'e-mail que vous avez saisie n'est pas valide.");
            }
            $this->user->email = $email;
            if (UsersTable::updateAccount($this->user->id, $this->user->email)) {
                Session::setFlashbag('Votre e-mail a été modifié', 'success');
                header('Location: /?view=accountSettings');
            }
        } catch (\Throwable $e) {
            Session::setFlashbag($e->getMessage(), 'error');
            header('Location: /?view=accountSettings');
        }
    }

    private function updatePassword(string $password, string $newPassword, string $newPasswordConfirmation)
    {
        try {
            if (!password_verify($password, $this->user->password)) {
                throw new Exception('Le mot de passe que vous avez saisis est incorrect');
            }
            if ($newPassword !== $newPasswordConfirmation) {
                throw new Exception('Les mots de passe saisis ne sont pas identiques');
            }
            $this->user->password = password_hash($newPassword, PASSWORD_DEFAULT);
            if (UsersTable::updatePassword($this->user->id, $this->user->password)) {
                Session::setFlashbag('Votre mot de passe a été modifié', 'success');
                header("Location: /?view=accountSettings");
            }
        } catch (Exception $e) {
            Session::setFlashbag($e->getMessage(), 'error');
            header('Location: /?view=accountSettings');
        }
    }

    private function deleteAccount(string $password)
    {
        try {
            if (!password_verify($password, $this->user->password)) {
                throw new Exception('Le mot de passe que vous avez saisis est incorrect');
            }
            if (UsersTable::delete($this->user->id)) {
                Session::setFlashbag('Votre compte a été supprimé', 'success');
                Session::unset('user');
                Session::set('user', ['role' => UsersTable::ROLE_ANONYMOUS]);
                header("Location: /");
            }
        } catch (Exception $e) {
            Session::setFlashbag($e->getMessage(), 'error');
            header('Location: /?view=accountSettings');
        }
    }
}
