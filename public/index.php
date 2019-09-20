<?php

require_once('Autoloader.php');
Autoloader::registerControllers();

try {
	$controller = new HomeController();
	$controller->execute($_GET);
} catch (\Exception $e) {
	$errorMessage = $e->getMessage();
}
