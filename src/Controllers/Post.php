<?php

namespace App\Controllers;

use App\Controllers\Base;
use App\Helpers\Redirect;
use App\Core\Http\Request;
use App\Services\PublishPost;
use App\Core\Database\Connection;
use App\Repositories\Post as PostRepository;
use App\Repositories\User as UserRepository;
use App\Repositories\Category as CategoryRepository;

class Post extends Base
{

    private $postRepository;
    private $categoryRepository;
    private $userRepository;
    private $userAuth;


    public function __construct()
    {
        parent::__construct();
        $this->postRepository = new PostRepository(Connection::getInstance());
        $this->categoryRepository = new CategoryRepository(Connection::getInstance());
        $this->userRepository = new UserRepository(Connection::getInstance());
        $this->userAuth = $this->userRepository->findBy('id', 1, false);
    }

    public function index()
    {
        return $this->view->render('post.index', [
            'posts' => $this->postRepository->findBy('p.author', $this->userAuth->id()),
            'categories' => $this->categoryRepository->all()
        ]);
    }

    public function store(Request $request)
    {
        try {
            $postData = (object) $request->getBody();
            $postData->user = $this->userAuth;
            $publishPostService = new PublishPost(
                $this->postRepository,
                $this->categoryRepository,
                $this->userRepository,
            );
            $publishPostService->publish($postData);
            Redirect::to('/admin/posts');
        } catch (\Throwable $th) {
            throw $th;
        }
    }
}
