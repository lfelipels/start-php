<?php

namespace App\Controllers;

use App\Controllers\Base;
use App\Helpers\Redirect;
use App\Core\Http\Request;
use App\Services\PublishPost;
use App\Core\Database\Connection;
use App\Core\Validation\Validator;
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

            $validator = Validator::make($request->getBody(), [
                'title' => ['between:2020-10-10,2020-10-20']
            ], [
                'title' => [
                    'required' => "O campo Título é de preenchimento obrigatório",
                    'max' => "O campo Título naõ deve ter mais de 10 caracteres",
                    'equals' => "O campo titulo deve ser igual ao texto",
                    'between' => "O valor do campo titulo deve ser um valor entre 10 e 20"
                ]
            ]);


            $validator->validate();

            dd($validator->errors());

            $postData = (object) $request->getBody();
            $postData->user = $this->userAuth;
            $publishPostService = new PublishPost(
                $this->postRepository,
                $this->categoryRepository,
                $this->userRepository,
            );
            $publishPostService->publish($postData);
            flash()->set('success', true);
            flash()->set('message', 'Post publicado com sucesso!');
            Redirect::to('/admin/posts');
        } catch (\DomainException|\InvalidArgumentException $e) {
            throw $e;
            flash()->set('success', false);
            flash()->set('message', $e->getMessage());
            Redirect::to('/admin/posts');
        } catch (\Exception $e) {
            flash()->set('success', false);
            flash()->set('message', 'Não foi possivel publicar o post');
            Redirect::to('/admin/posts');
        }
    }
}
