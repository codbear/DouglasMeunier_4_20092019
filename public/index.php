<?php

require_once('../vendor/autoload.php');

use Codbear\Alaska\Router;

session_start();
if (!isset($_SESSION['role'])) {
    $_SESSION['role'] = 3;
}

Router::init();

// TODO: Database::init();
