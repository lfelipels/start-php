<?php

namespace App\Models;

use DateTimeImmutable;
use App\Models\BaseModel;

class User extends BaseModel
{
    private string $name;
    private string $email;
    private string $password;

    public function __construct(
        string $name,
        string $email,
        string $password,
        ?int $id = null,
        ?DateTimeImmutable $createdAt = null,
        ?DateTimeImmutable $updatedAt = null,
        ?DateTimeImmutable $deletedAt = null
    ) {
        parent::__construct($id, $createdAt, $updatedAt, $deletedAt);
        $this->name = $name;
        $this->email = $email;
        $this->password = $password;
    }

    
    public function password(): string
    {
        return $this->password;
    }

    public function name(): string
    {
        return $this->name;
    }

    public function email(): string
    {
        return $this->email;
    }
}
