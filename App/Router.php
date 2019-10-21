<?php

namespace Codbear\Alaska;

use Codbear\Alaska\Controllers\HomeController;
use Codbear\Alaska\Controllers\LoginController;
use Codbear\Alaska\Controllers\ErrorsController;
use Codbear\Alaska\Controllers\DashboardController;

abstract class Router {

    public static function init() {
        try {
        	if (isset($_GET['view'])) {
        		switch ($_GET['view']) {
        			case 'login':
        				$controller = new LoginController();
						break;
						
					case 'dashboard':
						$controller = new DashboardController();
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
    }
}
