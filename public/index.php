<?php

session_start();

require_once('Autoloader.php');
Autoloader::registerControllers();

try {
	if (isset($_GET['view'])) {
		switch ($_GET['view']) {
			case 'login':
				$controller = new LoginController();
				break;

			default:
				$controller = new ErrorsController();
				break;
		}
	} else {
		$controller = new HomeController();
	}
	$controller->execute($_GET, $_POST);
} catch (\Exception $e) {
	$errorMessage = $e->getMessage();
	echo $errorMessage;
}
