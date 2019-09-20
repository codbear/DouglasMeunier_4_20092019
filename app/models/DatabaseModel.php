<?php

class Database {

	protected function dbConnect() {
		$config = file_get_contents('../config.json');
		$config = json_decode($config, true);
		$db = new \PDO('mysql:host=' .$config['dbhost']. ';dbname=' . $config['dbname'] . ';charset=utf8', $config['dblogin'], $config['dbpassword']);
        return $db;
	}
}
