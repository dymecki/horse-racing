<?php

declare(strict_types = 1);

namespace App\Domain\Model\Race;

use App\Application\DtoAssemblers\RaceDtoAssembler;
use App\Application\DtoAssemblers\Dto\RaceDto;

final class RaceDtoIterator implements \Iterator
{
    private $collection;
    private $key;

    public function __construct(RaceCollection $collection)
    {
        $this->collection = $collection;
    }

    public function current(): RaceDto
    {
        return (new RaceDtoAssembler($this->collection->get($this->key)))->dto();
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

    public function isEmpty(): bool
    {
        return $this->collection->isEmpty();
    }
}
