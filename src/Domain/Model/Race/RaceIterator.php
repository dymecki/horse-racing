<?php

declare(strict_types = 1);

namespace App\Domain\Model\Race;

final class RaceIterator implements \Iterator
{
    private $collection;
    private $key;

    public function __construct(RaceCollection $collection)
    {
        $this->collection = $collection;
    }

    public function current(): Race
    {
        return $this->collection->get($this->key);
    }

    public function key(): int
    {
        return $this->key;
    }

    public function next(): void
    {
        $this->key++;
    }

    public function rewind(): void
    {
        $this->key = 0;
    }

    public function valid(): bool
    {
        return $this->collection->isset($this->key);
    }
}
