<?php

use Slim\Factory\AppFactory;

require_once __DIR__ . '/../vendor/autoload.php';

ini_set('display_errors', 1);
ini_set('display_startup_errors', 1);
error_reporting(E_ALL);

//configs

$app = AppFactory::create();

//create routes
include __DIR__ . '/../routes/admin.php';

//start app
$app->run();



