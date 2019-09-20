<?php

require_once('../app/models/DatabaseModel.php');

class LoginModel extends DatabaseModel {

	public function registerUser($username, $email, $password, $role) {
		$db = $this->dbConnect();
        $req = $db->prepare('INSERT INTO users(username, password, email, role_id)
                                        VALUES (?, ?, ?, ?)');
        $affectedLines = $req->execute(array($username, $password, $email, $role));

        return $affectedLines;
	}
}
