<?php

use App\Core\App;
use App\Core\Http\Request;
use App\Core\Http\Router;

require_once __DIR__ . '/../vendor/autoload.php';

ini_set('display_errors', 1);
ini_set('display_startup_errors', 1);
error_reporting(E_ALL);

//configs

//create routes
$router = new Router();
include __DIR__ . '/../routes/admin.php';

//start app
$app = new App(new Request, $router);
$app->run();