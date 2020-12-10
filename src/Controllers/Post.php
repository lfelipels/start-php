<?php

namespace App\Controllers;

use App\Controllers\Base;
use App\Core\Database\Connection;
use App\Repositories\Post as PostRepository;

class Post extends Base
{

    private $postRepository;

    public function __construct()
    {
        parent::__construct();
        $this->postRepository = new PostRepository(Connection::getInstance());
    }

    public function index()
    {
        $this->view->render('post.index', [
            'posts' => $this->postRepository->findBy('p.author', 1)
        ]);
    }
}
