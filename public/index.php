<?php

session_start();

require_once('Autoloader.php');
require_once('Router.php');
Autoloader::registerControllers();
Router::init();
