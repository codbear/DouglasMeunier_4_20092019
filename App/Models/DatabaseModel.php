<?php

namespace Codbear\Alaska\Models;

class DatabaseModel {

	protected static function dbConnect() {
		$config = file_get_contents('../config.json');
		$config = json_decode($config, true);
		$db = new \PDO('mysql:host=' .$config['dbhost']. ';dbname=' . $config['dbname'] . ';charset=utf8', $config['dblogin'], $config['dbpassword']);
		$db->setAttribute(\PDO::ATTR_ERRMODE, \PDO::ERRMODE_EXCEPTION);
		return $db;
	}
}
