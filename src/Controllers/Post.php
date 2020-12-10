<?php

namespace App\Controllers;

use App\Models\User as UserModel;
use Slim\Psr7\Request;
use App\Controllers\Base;
use App\Core\Database\Connection;
use App\Helpers\Redirect;
use App\Models\Post as PostModel;
use Psr\Http\Message\ResponseInterface;
use App\Repositories\Post as PostRepository;
use App\Repositories\Category as CategoryRepository;
use App\Repositories\User as UserRepository;
use App\Services\PublishPost;

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
        $this->view->render('post.index', [
            'posts' => $this->postRepository->findBy('p.author', $this->userAuth->id()),
            'categories' => $this->categoryRepository->all()
        ]);
    }

    public function store(Request $request, ResponseInterface $response)
    {
        try {
            $postData = (object) $request->getParsedBody();
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
        die();
    }
}
