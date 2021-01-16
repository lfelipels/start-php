<?php

namespace App\Repositories;

use App\Core\Collection\CollectionInterface;
use PDO;
use App\Models\Post as PostModel;
use App\Models\Category;
use App\Models\User;
use DateTimeImmutable;

class Post
{
    use WithModelMapper;

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
     * @return CollectionInterface|\App\Models\Post|null
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
            return !empty($result) ? $this->mapFromArray($result) : [];
        }

        return $result ? $this->mapModel($result) : null;
    }

    public function all(): CollectionInterface
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
        return !empty($postList) ? $this->mapFromArray($postList) : [];
    }

    protected function mapModel($data): PostModel
    {
        return new PostModel(
            $data->title,
            $data->content,
            new User($data->author_name, $data->author_email, $data->author_password, $data->author_id),
            new Category($data->cat_description, null, $data->cat_id),
            $data->id,
            new DateTimeImmutable($data->created_at),
            new DateTimeImmutable($data->updated_at),
        );
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
