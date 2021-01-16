<?php

namespace App\Core\Collection;

use IteratorAggregate;
use App\Core\Collection\CollectionInterface;
use ArrayIterator;
use CallbackFilterIterator;

class Colletion implements CollectionInterface, IteratorAggregate
{

    private $items = [];

    public function __construct(array $items)
    {
        $this->items = new ArrayIterator($items);
    }

    public function add($newValue): void
    {
        $this->items->append($newValue);
    }

    public function contains($value): bool
    {
        if ($this->isEmpty()) return false;

        $hasValue = false;

        if ($value instanceof \Closure) {
            $hasValue = !$this->filter($value)->isEmpty();
        } else {
            $hasValue = !$this->filter(fn ($currentValue) => $currentValue == $value)->isEmpty();
        }

        return $hasValue;
    }

    public function clear(): void
    {
        $this->items = new ArrayIterator([]);
    }

    public function isEmpty(): bool
    {
        return $this->items->count() == 0;
    }

    public function toArray(): array
    {
        return iterator_to_array($this->items);
    }

    public function map(\Closure $callback): CollectionInterface
    {
        $itemsMaper = [];
        foreach ($this->items as $key => $value) {
            $itemsMaper[$key] = $callback($value, $key);
        }
        $this->items = new ArrayIterator($itemsMaper);
        return $this;
    }

    public function filter(\Closure $callback): CollectionInterface
    {
        $result = new CallbackFilterIterator($this->getIterator(), $callback);

        return new static(iterator_to_array($result));
    }

    public function count(): int
    {
        return $this->items->count();
    }

    public function getIterator()
    {
        return $this->items;
    }
}
