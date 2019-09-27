<?php

namespace Codbear\Alaska\Models;

use Codbear\Alaska\Models\DatabaseModel;

class UserModel extends DatabaseModel {

    const ROLE_ADMIN = 1;
    const ROLE_SUBSCRIBER = 2;
    const ROLE_ANONYMOUS = 3;
    const ROLE_DEFAULT = self::ROLE_SUBSCRIBER;

    private $_username;
    private $_email;
    private $_role;

    public function __construct() {
        $this->setRole(self::ROLE_DEFAULT);
    }

    public function getUsername() {
        return $this->_username;
    }

    public function getEmail() {
        return $this->_email;
    }

    public function getRole() {
        return $this->_role;
    }

    public function setUsername($username) {
        $this->_username = $username;
    }

    public function setEmail($email) {
        $this->_email = $email;
    }

    public function setRole($role) {
        $this->_role = $role;
    }

	public function register($passwordHash) {
		$db = $this->dbConnect();
        $req = $db->prepare('INSERT INTO users(username, password, email, role_id)
                                        VALUES (?, ?, ?, ?)');
        $affectedLines = $req->execute(array($this->_username, $passwordHash, $this->_email, $this->_role));
        return $affectedLines;
    }
    
    public static function checkUsernameInDatabase($username) {
        $db = self::dbConnect();
        $req = $db->prepare('SELECT username
                                    FROM users
                                    WHERE username = ?');
        $req->execute(array($username));
        $response = $req->fetch();
        return $response['username'];
    }

    public static function checkEmailInDatabase($email) {
        $db = self::dbConnect();
        $req = $db->prepare('SELECT email
                                    FROM users
                                    WHERE email = ?');
        $req->execute(array($email));
        $response = $req->fetch();
        return $response['email'];
    }

    public function getPasswordFromDatabase() {
        $db = $this->dbConnect();
        $req = $db->prepare('SELECT password, email, role_id
                                    FROM users
                                    WHERE username = ?');
        $req->execute(array($this->_username));
        $response = $req->fetch();
        return $response['password'];
    }

    public function hydrateUser() {
        $db = $this->dbConnect();
        $req = $db->prepare('SELECT email, role_id
                                    FROM users
                                    WHERE username = ?');
        $req->execute(array($this->_username));
        $response = $req->fetch();
        $this->setEmail($response['email']);
        $this->setRole($response['role_id']);
    }
}
