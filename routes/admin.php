<?php

use App\Controllers\Post;

$app->get('/posts', Post::class . ':index');