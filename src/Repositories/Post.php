<?php

namespace App\Repositories;

use PDO;
use App\Models\Post as PostModel;
use App\Models\Category;
use App\Models\User;
use DateTimeImmutable;

class Post
{
    private PDO $connection;

    public function __construct(PDO $connection)
    {
        $this->connection = $connection;
    }

    public function findBy($field, $value)
    {
        $sql = "SELECT 
                    p.id, p.title, p.content, p.created_at, p.updated_at,
                    u.name as author_name, u.id as author_id, u.email as author_email, u.password as author_password, 
                    c.description as cat_description, c.id as cat_id
                FROM posts as p
                    INNER JOIN users as u ON p.author = u.id
                    INNER JOIN categories as c ON p.category_id = c.id
                    LEFT JOIN categories as cp ON cp.id = c.parent_id
                WHERE
                    p.deleted_at IS NULL AND 
                    {$field} = :valueField";
                    
        $query = $this->connection->prepare($sql);
        $query->bindValue(':valueField', $value);
        $query->execute();
        $postList = $query->fetchAll();
        return !empty($postList) ? $this->postMapper($postList) : [];
    }

    public function all(): array
    {
        $sql = "SELECT 
                    p.id, p.title, p.content, p.created_at, p.updated_at,
                    u.name as author_name, u.id as author_id, u.email as author_email, u.password as author_password, 
                    c.description as cat_description, c.id as cat_id
                FROM posts as p
                    INNER JOIN users as u ON p.author = u.id
                    INNER JOIN categories as c ON p.category_id = c.id
                    LEFT JOIN categories as cp ON cp.id = c.parent_id
                WHERE p.deleted_at IS NULL;";

        $query = $this->connection->query($sql);
        $postList = $query->fetchAll();
        return !empty($postList) ? $this->postMapper($postList) : [];
    }

    /**
     * Mapper Post Entity
     *
     * @param array $postList
     * @return array
     */
    private function postMapper(array $postList)
    {
        return array_map(function ($p) {
            return new PostModel(
                $p->title,
                $p->content,
                new User($p->author_name, $p->author_email, $p->author_password, $p->author_id),
                new Category($p->cat_description, null, $p->cat_id),
                $p->id,
                new DateTimeImmutable($p->created_at),
                new DateTimeImmutable($p->updated_at),
            );
        }, $postList);
    }

    public function save(PostModel $post): PostModel
    {
        $sql = "INSERT INTO posts(title, content, author, category_id, created_at)
                VALUES(:title, :content, :author, category_id, NOW());";

        $query = $this->connection->prepare($sql);
        $query->bindValue(':title', $post->title());
        $query->bindValue(':content', $post->content());
        $query->bindValue(':author', $post->author()->id());
        $query->bindValue(':category_id', $post->category()->id());
        $query->execute();

        return new PostModel(
            $post->title(),
            $post->content(),
            $post->author(),
            $post->category(),
            $this->connection->lastInsertId()
        );
    }
}
