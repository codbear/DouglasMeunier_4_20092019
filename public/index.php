<?php

require_once('../app/controllers/HomeController.php');

try {
	$controller = new HomeController();
	$controller->execute($_GET);
} catch (\Exception $e) {
	$errorMessage = $e->getMessage();
}
