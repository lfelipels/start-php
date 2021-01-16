<?php

namespace App\Repositories;

use App\Core\Collection\CollectionInterface;
use PDO;
use App\Models\User as UserModel;
use DateTimeImmutable;

class User
{
    use WithModelMapper;

    private PDO $connection;

    public function __construct(PDO $connection)
    {
        $this->connection = $connection;
    }

    public function findBy(string $field, string $value, bool $all = true)
    {
        $sql = "SELECT * FROM users WHERE deleted_at IS NULL AND {$field} = :valueField;";
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
        $sql = "SELECT * FROM users WHERE deleted_at IS NULL;";
        $query = $this->connection->query($sql);
        $userList = $query->fetchAll();
        return !empty($userList) ? $this->mapFromArray($userList) : [];
    }

    /**
     * Mapper User Entity
     *
     * @param array $userList
     * @return UserModel
     */
    protected function mapModel($user): UserModel
    {
        return new UserModel(
            $user->name,
            $user->email,
            $user->password,
            $user->id,
            new \DateTimeImmutable($user->created_at),
            new \DateTimeImmutable($user->updated_at)
        );
    }
}
