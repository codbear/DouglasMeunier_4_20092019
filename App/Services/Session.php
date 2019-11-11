<?php

namespace Codbear\Alaska\Services;

use Codbear\Alaska\Models\UserModel;

class Session
{
    public static function start()
    {
        session_start();
        if (!isset($_SESSION['role'])) {
            $_SESSION['role'] = UserModel::ROLE_ANONYMOUS;
        }
    }

    public static function set(string $key, $value)
    {
        $_SESSION[$key] = $value;
    }

    public static function get(string $key)
    {
        if (isset($_SESSION[$key])) {
            return $_SESSION[$key];
        }
    }

    public static function unset(string $key) {
        if (isset($_SESSION[$key])) {
            unset($_SESSION[$key]);
        }
    }

    public static function setUser($user)
    {
        self::set('username', $user->getUsername());
        self::set('role', $user->getRole());
    }

    public static function unsetUser()
    {
        self::unset('username');
        self::set('role', UserModel::ROLE_ANONYMOUS);
    }

    public static function setFlash($message, $type = 'info')
    {
        self::set('flashbag', [
            'message'   => $message,
            'type'      => $type
        ]);
    }

    public static function flashbag()
    {
        if (self::get('flashbag')) {
            $flashMessage = '<div class="valign-wrapper alert alert-' . self::get('flashbag')['type'] . '">
                                <i class="alert-icon material-icons">';
            switch (self::get('flashbag')['type']) {
                case 'success':
                    $flashMessage .= 'check';
                    break;
    
                case 'warning':
                    $flashMessage .= 'warning';
                    break;
    
                case 'error':
                    $flashMessage .= 'error_outline';
                    break;
    
                default:
                    $flashMessage .= 'info_outline';
                    break;
            }
            $flashMessage .= '</i>'. self::get('flashbag')['message'] . '</div>';
            self::unset('flashbag');
            return $flashMessage;
        }
    }
}
