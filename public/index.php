<?php

require_once('../vendor/autoload.php');

use Codbear\Alaska\Services\Database;
use Codbear\Alaska\Services\Router;
use Codbear\Alaska\Services\Session;

function protect($value) {
    return htmlentities($value, ENT_QUOTES);
}

Session::start();
Database::init(dirname(__DIR__) . '/config.json');
Router::init();
