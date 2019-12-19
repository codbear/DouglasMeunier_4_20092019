<?php

namespace Codbear\Alaska\Controllers\Dashboard;

use Exception;
use Codbear\Alaska\Services\Session;
use Codbear\Alaska\Models\Tables\UsersTable;
use Codbear\Alaska\Interfaces\ControllerInterface;
use Codbear\Alaska\Controllers\Dashboard\DashboardController;

class UsersPanelController extends DashboardController implements ControllerInterface
{
    public function execute(array $params, array $datas)
    {
        if (isset($params['action'])) {
            switch ($params['action']) {
                case 'deleteUser':
                    if (isset($params['userId'])) {
                        $this->delete($params['userId']);
                    }
                    break;
                
                default:
                    return $this->notFound();
                    break;
            }
        } else {
            $users = UsersTable::getAll();
            return $this->renderer->render('dashboard/usersPanel', [
                'title' => 'Utilisateurs | Dashboard',
                'users' => $users
            ]);
        }
    }

    private function delete(int $userId) {
        try {
            if (UsersTable::getRole((int) $userId) == UsersTable::ROLE_ADMIN) {
                throw new Exception("Vous ne pouvez pas supprimer un compte administrateur");
            }
            if (!UsersTable::delete((int) $userId)) {
                throw new Exception("Une erreur innatendue est survenue. Merci de réessayer ultérieurement");
            }
            header('Location: /?view=usersPanel');
        } catch (Exception $e) {
            Session::setFlashbag($e->getMessage(), 'error');
            header('Location: /?view=usersPanel');
        }
    }
}
