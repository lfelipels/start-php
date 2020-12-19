<?php

use App\Controllers\Post;

$router->get('/admin/posts', [Post::class, 'index']);
$router->post('/admin/posts', [Post::class, 'store']);
