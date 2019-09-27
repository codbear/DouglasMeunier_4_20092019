<?php

require_once('../vendor/autoload.php');

use Codbear\Alaska\Router;
use Codbear\Alaska\Session;

Session::start();
Router::init();

// TODO: Database::init();
