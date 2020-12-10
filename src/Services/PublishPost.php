<?php

namespace App\Services;

use App\Models\Post;
use App\Repositories\Post as PostRepository;
use App\Repositories\Category as CategoryRepository;
use App\Repositories\User as UserRepository;

class PublishPost
{

    private CategoryRepository $categoryRepository;
    private PostRepository $postRepository;
    private UserRepository $userRepository;


    public function __construct(
        PostRepository $postRepository,
        CategoryRepository $categoryRepository,
        UserRepository $userRepository
    ) {
        $this->postRepository = $postRepository;
        $this->categoryRepository = $categoryRepository;
        $this->userRepository = $userRepository;
    }

    public function publish(object $postData)
    {
        $category = $this->categoryRepository->findBy('id', $postData->category, false);
        if(!$category){
            throw new \DomainException("Categoria não encontrada.");
        }
        
        $user = $this->userRepository->findBy('id', $postData->user->id(), false);
        if(!$user){
            throw new \DomainException("Usuario não encontrado.");
        }

        $titleExists = $this->postRepository->findBy('title', $postData->title);        
        if($titleExists){
            throw new \DomainException("Já existe um post com o título {$postData->title}. Favor crie um nov post com título diferente.");
        }

        $post = new Post(
            $postData->title,
            $postData->content,
            $user,
            $category
        );

        $this->postRepository->save($post);
    }
}
