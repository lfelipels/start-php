<?php

namespace App\Repositories;

use App\Core\Collection\CollectionInterface;
use App\Core\Collection\Colletion;
use PDO;
use App\Models\Category as CategoryModel;
use DateTimeImmutable;

class Category
{

    use WithModelMapper;

    private PDO $connection;

    public function __construct(PDO $connection)
    {
        $this->connection = $connection;
    }

    /**
     * find category by field and value
     *
     * @param string $field
     * @param string $value
     * @param boolean $all
     * @return CollectionInterface|\App\Models\Category|null
     */
    public function findBy(string $field, string $value, bool $all = true)
    {
        $sql = "SELECT * FROM categories WHERE deleted_at IS NULL AND {$field} = :valueField;";                    
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
        $sql = "SELECT * FROM categories WHERE deleted_at IS NULL;";
        $query = $this->connection->query($sql);
        $categoryList = $query->fetchAll();
        return !empty($categoryList) ? $this->mapFromArray($categoryList) : [];
    }

    protected function mapModel($data): CategoryModel
    {
        return new CategoryModel(
            $data->description,
            null,
            $data->id,
            new \DateTimeImmutable($data->created_at),
            new \DateTimeImmutable($data->updated_at)
        );
    }
}
