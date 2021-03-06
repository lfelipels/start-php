<?php

declare(strict_types=1);

use App\Core\App;
use App\Core\Http\Request;
use App\Core\Http\Router;

require_once __DIR__ . '/../vendor/autoload.php';

ini_set('display_errors', 'On');
ini_set('display_startup_errors', 'ON');
error_reporting(E_ALL);

//configs
$dotenv = Dotenv\Dotenv::createImmutable(__DIR__ . '/..', '.env');
$dotenv->load();

//create routes
$router = new Router();
include __DIR__ . '/../routes/admin.php';

//start app
$app = new App(new Request, $router);
$app->run();
