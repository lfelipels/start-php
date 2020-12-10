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

    /**
     * find post by field and value
     *
     * @param string $field
     * @param string $value
     * @param boolean $all
     * @return array|\App\Models\Post|null
     */
    public function findBy(string $field, string $value, bool $all = true)
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
        $result = $all ? $query->fetchAll() : $query->fetch();

        if (is_array($result)) {
            return !empty($result) ? $this->postArrayMapper($result) : [];
        }

        return $result ? $this->postMapper($result) : null;
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
        return !empty($postList) ? $this->postArrayMapper($postList) : [];
    }

    private function postMapper(Object $post)
    {
        return new PostModel(
            $post->title,
            $post->content,
            new User($post->author_name, $post->author_email, $post->author_password, $post->author_id),
            new Category($post->cat_description, null, $post->cat_id),
            $post->id,
            new DateTimeImmutable($post->created_at),
            new DateTimeImmutable($post->updated_at),
        );
    }

    /**
     * Mapper Post Entity
     *
     * @param array $postList
     * @return array
     */
    private function postArrayMapper(array $postList): array
    {
        return array_map(function ($post) {
            return $this->postMapper($post);
        }, $postList);
    }

    public function save(PostModel $post): PostModel
    {
        $sql = "INSERT INTO posts(title, content, author, category_id, created_at)
                VALUES(:title, :content, :author, :category, NOW());";

        $query = $this->connection->prepare($sql);
        $query->bindValue(':title', $post->title());
        $query->bindValue(':content', $post->content());
        $query->bindValue(':author', $post->author()->id());
        $query->bindValue(':category', $post->category()->id());
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
