<?php

namespace App\Core;

interface CollectionInterface {
    public function add($newValue): void;
    public function contains($value): bool;
    public function clear(): void;
    public function copy(): CollectionInterface;
    public function isEmpty(): bool;
    public function filter(\Closure $callback): CollectionInterface;
    public function map(\Closure $callback): CollectionInterface;
    public function toArray(): array;
}