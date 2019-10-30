<?php

namespace Codbear\Alaska;

use Codbear\Alaska\Models\UserModel;

class Session
{
    public static function start() {
        session_start();
        if (!isset($_SESSION['role'])) {
            $_SESSION['role'] = UserModel::ROLE_ANONYMOUS;
        }
    }

    public static function setUser($user) {
        $_SESSION['username'] = $user->getUsername();
        $_SESSION['role'] = $user->getRole();
    }

    public static function unsetUser() {
        unset($_SESSION['username']);
        $_SESSION['role'] = UserModel::ROLE_ANONYMOUS;
    }

    public static function setFlash($message, $type = 'info') {
        $_SESSION['flashbag'] = [
            'message'   => $message,
            'type'      => $type
        ];
    }
}
