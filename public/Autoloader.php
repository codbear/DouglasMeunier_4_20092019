<?php

class Autoloader {

	public static function registerControllers() {
		spl_autoload_register(array(__CLASS__, 'autoloadControllers'));
	}

	private static function autoloadControllers($class_name) {
		require_once '../App/Controllers/' . $class_name . '.php';
	}
}
