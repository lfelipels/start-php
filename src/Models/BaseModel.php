<?php

namespace App\Models;

use DateTimeImmutable;

abstract class BaseModel
{
    private ?int $id = null;
    private ?DateTimeImmutable $createdAt = null;
    private ?DateTimeImmutable $updatedAt = null;
    private ?DateTimeImmutable $deletedAt = null;


    public function __construct(
        ?int $id,
        ?DateTimeImmutable $createdAt = null,
        ?DateTimeImmutable $updatedAt = null,
        ?DateTimeImmutable $deletedAt = null
    ) {
        $this->id = $id;
        $this->createdAt = $createdAt;
        $this->updatedAt = $updatedAt;
        $this->deletedAt = $deletedAt;
    }

    public function id(): ?int
    {
        return $this->id;
    }


    public function createdAt(): DateTimeImmutable
    {
        return $this->createdAt;
    }


    public function updatedAt(): DateTimeImmutable
    {
        return $this->updatedAt;
    }


    public function deletedAt(): DateTimeImmutable
    {
        return $this->deletedAt;
    }
}
