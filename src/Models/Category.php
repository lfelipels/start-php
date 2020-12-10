<?php

namespace App\Models;

use App\Models\BaseModel;
use DateTimeImmutable;

class Category extends BaseModel
{
    private string $description;
    private ?Category $parent;

    public function __construct(
        $description,
        ?Category $parent = null,
        ?int $id = null,
        ?DateTimeImmutable $createdAt = null,
        ?DateTimeImmutable $updatedAt = null,
        ?DateTimeImmutable $deletedAt = null
    ) {
        parent::__construct($id, $createdAt, $updatedAt, $deletedAt);
        $this->description = $description;
        $this->parent = $parent;
    }

   
    public function description(): string
    {
        return $this->description;
    }

    public function parent(): ?Category
    {
        return $this->parent;
    }
}
