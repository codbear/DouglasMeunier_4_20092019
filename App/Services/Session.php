<?php

namespace Codbear\Alaska\Services;

use Codbear\Alaska\Models\UsersModel;

class Session
{
    public static function start()
    {
        session_start();
        if (!isset($_SESSION['user'])) {
            self::set('user', ['role' => UsersModel::ROLE_ANONYMOUS]);
        }
    }

    public static function set(string $key, $value): void
    {
        $_SESSION[$key] = $value;
    }

    public static function get(string $key)
    {
        if (isset($_SESSION[$key])) {
            return $_SESSION[$key];
        }
    }

    public static function isSet(string $key): bool
    {
        return isset($_SESSION[$key]);
    }

    public static function unset(string $key): void
    {
        if (isset($_SESSION[$key])) {
            unset($_SESSION[$key]);
        }
    }

    public static function setFlashbag($message, $type = 'info'): void
    {
        self::set('flashbag', compact('message', 'type'));
    }

    public static function getFlashbag(): array
    {
        $type = self::get('flashbag')['type'];
        switch ($type) {
            case 'success':
                $icon = 'check';
                break;

            case 'warning':
                $icon = 'warning';
                break;

            case 'error':
                $icon = 'error_outline';
                break;

            default:
                $icon = 'info_outline';
                break;
        }
        $message = self::get('flashbag')['message'];
        self::unset('flashbag');
        return compact('type', 'icon', 'message');
    }
}
