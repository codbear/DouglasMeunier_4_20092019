<?php

namespace Codbear\Alaska\Models\Tables;

use Codbear\Alaska\Services\Database;

abstract class UsersTable
{

    const ROLE_ADMIN = 1;
    const ROLE_SUBSCRIBER = 2;
    const ROLE_ANONYMOUS = 3;
    const ROLE_DEFAULT = self::ROLE_SUBSCRIBER;
    const USER_ENTITY_CLASS = "Codbear\\Alaska\\Models\\Entity\\UserEntity";

    public static function getAll()
    {
        $statement = 'SELECT u.id, u.username, u.email, r.role AS role
                        FROM users AS u
                        INNER JOIN roles AS r
                            ON u.role = r.id';
        return Database::query($statement, Database::FETCH_ALL, self::USER_ENTITY_CLASS);
    }

    public static function get($username)
    {
        $statement = 'SELECT id, username, password, email, role 
                        FROM users
                        WHERE username = ?';
        return Database::prepare($statement, [$username], Database::FETCH_SINGLE, self::USER_ENTITY_CLASS);
    }

    public static function register($username, $password, $email, $role = self::ROLE_DEFAULT)
    {
        $statement = 'INSERT INTO users(username, password, email, role)
                        VALUES (:username, :password, :email, :role)';
        $datas = compact('username', 'password', 'email', 'role');
        return Database::prepare($statement, $datas, false);
    }

    public static function checkUsernameInDatabase($username)
    {
        $response = Database::prepare('SELECT username FROM users WHERE username = ?', [$username], Database::FETCH_SINGLE);
        return $response->username;
    }

    public static function checkEmailInDatabase($email)
    {
        $response = Database::prepare('SELECT email FROM users WHERE email = ?', [$email], Database::FETCH_SINGLE);
        return $response->email;
    }

    public static function getRole(int $id) {
        $response = Database::prepare('SELECT role FROM users WHERE id = ?', [$id], Database::FETCH_SINGLE);
        return $response->role;
    }

    public static function delete(int $id) {
        return Database::prepare('DELETE FROM users WHERE id = ?', [$id]);
    }

    public static function updateAccount(int $id, string $email) {
        $statement = 'UPDATE users
                        SET email = :email
                        WHERE id = :id';
        return Database::prepare($statement, compact('email', 'id'));
    }

    public static function updatePassword(int $id, string $password) {
        $statement = 'UPDATE users
                        SET password = :password
                        WHERE id = :id';
        return Database::prepare($statement, compact('password', 'id'));
    }
}
