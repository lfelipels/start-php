<?php

use App\Controllers\Post;

$app->get('/admin/posts', Post::class . ':index');
$app->post('/admin/posts', Post::class . ':store');