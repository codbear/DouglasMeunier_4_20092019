<?php

require_once('Autoloader.php');
Autoloader::registerControllers();

try {
	if (isset($_GET['view'])) {
		switch ($_GET['view']) {
			case 'login':
				$controller = new LoginController();
				break;

			default:
				// code...
				break;
		}
	} else {
		$controller = new HomeController();
	}
	$controller->execute($_GET);
} catch (\Exception $e) {
	$errorMessage = $e->getMessage();
}
