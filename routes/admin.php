<?php

use App\Controllers\Post;

$router->get('/', [Post::class, 'index']);
$router->get('/admin/posts', [Post::class, 'index']);
$router->post('/admin/posts', [Post::class, 'store']);
