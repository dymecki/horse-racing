<?php

declare(strict_types = 1);

namespace App\Domain\Model\Horse;

use App\Domain\Model\Race\HorseRun;

final class HorseRunCollection implements \IteratorAggregate, \Countable
{
    /** @var HorseRun */
    private $items;

    public function make(HorseRun ...$items)
    {
        $this->items = $items;
    }

    public function getIterator(): HorseRunIterator
    {
        return new HorseRunIterator($this);
    }

    public function getHorseRun(int $key): HorseRun
    {
        return $this->items[$key] ?? null;
    }

    public function addHorseRun(HorseRun $horseRun): void
    {
        $this->items[] = $horseRun;
    }

    public function last(): HorseRun
    {
        return end($this->items);
    }

    public function isEmpty(): bool
    {
        return $this->count() == 0;
    }

    public function isset($key): bool
    {
        return isset($this->items[$key]);
    }

    public function count(): int
    {
        return count($this->items);
    }
}
