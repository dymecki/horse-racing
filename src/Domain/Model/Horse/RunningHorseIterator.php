<?php

declare(strict_types = 1);

namespace App\Domain\Model\Horse;

use App\Domain\Model\Race\RunningHorse;
use App\Domain\Model\Horse\HorseCollection;

final class RunningHorseIterator implements \Iterator
{
    private $collection;
    private $key;

    public function __construct(HorseCollection $collection)
    {
        $this->collection = $collection;
    }

    public function current()
    {
        return $this->collection->getRunningHorse($this->key);
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
        return isset($this->collection[$this->key]);
    }
}
