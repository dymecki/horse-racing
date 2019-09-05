<?php

declare(strict_types = 1);

namespace App\Domain\Model\Horse;

use App\Domain\Model\Horse\HorseRunCollection;

final class HorseRunIterator implements \Iterator
{
    private $collection;
    private $key;

    public function __construct(HorseRunCollection $collection)
    {
        $this->collection = $collection;
    }

    public function current()
    {
        return $this->collection->getHorseRun($this->key);
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
