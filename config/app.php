<?php

use App\Core\Helpers\Env;

return [
    'env' => Env::get('APP_ENV', 'local'), //local, testing, production
    'debug' => Env::get('APP_DEBUG', true), //
    'url' => Env::get('APP_URL', 'http://localhost')
];