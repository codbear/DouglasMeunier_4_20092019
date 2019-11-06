<?php

require_once('../vendor/autoload.php');

use Codbear\Alaska\Services\Router;
use Codbear\Alaska\Services\Session;

Session::start();
Router::init();

// TODO: Database::init();
