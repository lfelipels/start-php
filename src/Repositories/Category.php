<?php

namespace App\Repositories;

use PDO;
use App\Models\Category as CategoryModel;
use DateTimeImmutable;

class Category
{
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
     * @return array|\App\Models\Category|null
     */
    public function findBy(string $field, string $value, bool $all = true)
    {
        $sql = "SELECT * FROM categories WHERE deleted_at IS NULL AND {$field} = :valueField;";                    
        $query = $this->connection->prepare($sql);
        $query->bindValue(':valueField', $value);
        $query->execute();
        $result = $all ? $query->fetchAll() : $query->fetch();

        if (is_array($result)) {
            return !empty($result) ? $this->categoryArrayMapper($result) : [];
        }

        return $result ? $this->categoryMapper($result) : null;
    }

    public function all(): array
    {
        $sql = "SELECT * FROM categories WHERE deleted_at IS NULL;";
        $query = $this->connection->query($sql);
        $categoryList = $query->fetchAll();
        return !empty($categoryList) ? $this->categoryArrayMapper($categoryList) : [];
    }

    /**
     * Mapper Category Entity
     *
     * @param array $categoryList
     * @return array
     */
    private function categoryMapper($category)
    {
        return new CategoryModel(
            $category->description,
            null,
            $category->id,
            new \DateTimeImmutable($category->created_at),
            new \DateTimeImmutable($category->updated_at)
        );
    }
    
    private function categoryArrayMapper(array $categoryList)
    {
        return array_map(function ($category) {
            return $this->categoryMapper($category);
        }, $categoryList);
    }
}
