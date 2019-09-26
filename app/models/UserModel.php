<?php

require_once('../app/models/DatabaseModel.php');

class UserModel extends DatabaseModel {

    const ADMIN = 1;
    const SUBSCRIBER = 2;
    const ANONYMOUS = 3;
    const DEFAULT_ROLE = self::SUBSCRIBER;

    private $_username;
    private $_email;
    private $_password;
    private $_role;

    public function getUsername() {
        return $this->_username;
    }

    public function getPassword() {
        return $this->_password;
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

    public function setPassword($password) {
        $this->_password = $password;
    }

    public function setEmail($email) {
        $this->_email = $email;
    }

    public function setRole($role) {
        $this->_role = $role;
    }

	public function register() {
		$db = $this->dbConnect();
        $req = $db->prepare('INSERT INTO users(username, password, email, role_id)
                                        VALUES (?, ?, ?, ?)');
        $affectedLines = $req->execute(array($this->_username, $this->_password, $this->_email, self::DEFAULT_ROLE));

        return $affectedLines;
	}

    public function login($username) {
        $db = $this->dbConnect();
        $req = $db->prepare('SELECT password
                                    FROM users
                                    WHERE username = ?');
        $password = $req->execute(array($username));
        return $password;
    }
}
