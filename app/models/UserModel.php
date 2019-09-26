<?php

require_once('../app/models/DatabaseModel.php');

class UserModel extends DatabaseModel {

	public function register($username, $email, $password, $role) {
		$db = $this->dbConnect();
        $req = $db->prepare('INSERT INTO users(username, password, email, role_id)
                                        VALUES (?, ?, ?, ?)');
        $affectedLines = $req->execute(array($username, $password, $email, $role));

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
