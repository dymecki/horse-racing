<?php

declare(strict_types = 1);

namespace App\Domain\Model\Horse;

use App\Domain\Model\Race\HorseRun;

final class HorseRunCollection implements \IteratorAggregate
{
    private $items;

    public function getIterator(): HorseRunIterator
    {
        return new HorseRunIterator($this);
    }

    public function getHorseRun(int $key): HorseRun
    {
        return $this->items[$key] ?? null;
    }

    public function addHorseRun(HorseRun $horseRun)
    {
        $this->items[] = $horseRun;
    }

    public function __isset($key): bool
    {
        return isset($this->items[$key]);
    }
}
