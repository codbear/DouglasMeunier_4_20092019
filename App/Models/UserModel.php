<?php

namespace Codbear\Alaska\Models;

class UserModel extends Model
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
        parent::__construct();
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
        return $this->_db->prepare('INSERT INTO users(username, password, email, role_id) VALUES (?, ?, ?, ?)', [
            $this->_username,
            $passwordHash,
            $this->_email,
            $this->_role
        ], false);
    }

    public function checkUsernameInDatabase($username)
    {
        $response = $this->_db->prepare('SELECT username FROM users WHERE username = ?', [$username]);
        return $response->username;
    }

    public function checkEmailInDatabase($email)
    {
        $response = $this->_db->prepare('SELECT email FROM users WHERE email = ?', [$email]);
        return $response->email;
    }

    public function getPasswordFromDatabase()
    {
        $response = $this->_db->prepare('SELECT password, email, role_id FROM users WHERE username = ?', [$this->_username]);
        return $response->password;
    }

    public function hydrateUser()
    {
        $response = $this->_db->prepare('SELECT email, role_id FROM users WHERE username = ?', [$this->_username]);
        $this->setEmail($response->email);
        $this->setRole($response->role_id);
    }
}
