<?php

require_once('../vendor/autoload.php');

use Codbear\Alaska\Services\Database;
use Codbear\Alaska\Services\Router;
use Codbear\Alaska\Services\Session;

function debug($expression) {
    echo '<pre>';
    echo var_dump($expression);
    echo '</pre>';
    die;
}

Session::start();
Database::init(dirname(__DIR__) . '/config.json');
Router::init();
