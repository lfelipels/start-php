<?php

use App\Controllers\HomeControle;

$router->get('/', [HomeControle::class, 'index']);
