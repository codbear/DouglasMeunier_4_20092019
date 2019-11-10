<?php

namespace Codbear\Alaska\Models;

use Codbear\Alaska\Services\Database;

class UserModel
{

    const ROLE_ADMIN = 1;
    const ROLE_SUBSCRIBER = 2;
    const ROLE_ANONYMOUS = 3;
    const ROLE_DEFAULT = self::ROLE_SUBSCRIBER;

    private $_username;
    private $_email;
    private $_role;

    public function __construct()
    {
        $this->setRole(self::ROLE_DEFAULT);
    }

    public function getUsername()
    {
        return $this->_username;
    }

    public function getEmail()
    {
        return $this->_email;
    }

    public function getRole()
    {
        return $this->_role;
    }

    public function setUsername($username)
    {
        $this->_username = $username;
    }

    public function setEmail($email)
    {
        $this->_email = $email;
    }

    public function setRole($role)
    {
        $this->_role = $role;
    }

    public function register($passwordHash)
    {
        return Database::prepare('INSERT INTO users(username, password, email, role_id) VALUES (?, ?, ?, ?)', [
            $this->_username,
            $passwordHash,
            $this->_email,
            $this->_role
        ], false);
    }

    public function checkUsernameInDatabase($username)
    {
        $response = Database::prepare('SELECT username FROM users WHERE username = ?', [$username], Database::FETCH_SINGLE);
        return $response->username;
    }

    public function checkEmailInDatabase($email)
    {
        $response = Database::prepare('SELECT email FROM users WHERE email = ?', [$email], Database::FETCH_SINGLE);
        return $response->email;
    }

    public function getPasswordFromDatabase()
    {
        $response = Database::prepare('SELECT password FROM users WHERE username = ?', [$this->_username], Database::FETCH_SINGLE);
        return $response->password;
    }

    public function hydrateUser()
    {
        $response = Database::prepare('SELECT email, role_id FROM users WHERE username = ?', [$this->_username], Database::FETCH_SINGLE);
        $this->setEmail($response->email);
        $this->setRole($response->role_id);
    }
}
