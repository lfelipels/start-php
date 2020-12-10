<?php

namespace App\Models;

use App\Models\User;
use DateTimeImmutable;
use App\Models\Category;
use App\Models\BaseModel;

class Post extends BaseModel
{
    private string $title;
    private string $content;
    private User $author;
    private Category $category;

    public function __construct(
        string $title,
        string $content,
        User $author,
        Category $category,
        ?int $id = null,
        ?DateTimeImmutable $createdAt = null,
        ?DateTimeImmutable $updatedAt = null,
        ?DateTimeImmutable $deletedAt = null
    ) {
        parent::__construct($id, $createdAt, $updatedAt, $deletedAt);
        $this->title = $title;
        $this->content = $content;
        $this->author = $author;
        $this->category = $category;
        $this->id = $id;
    }

    public function category(): Category
    {
        return $this->category;
    }

    public function author(): User
    {
        return $this->author;
    }

    public function content(): string
    {
        return $this->content;
    }

    public function title(): string
    {
        return $this->title;
    }
}
