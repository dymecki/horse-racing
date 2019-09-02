<?php

declare(strict_types = 1);

namespace App\Domain\Model\Horse;

use App\Domain\Model\Race\RunningHorse;

final class HorseCollection implements \IteratorAggregate
{
    private $items;

    public function getIterator(): RunningHorseIterator
    {
        return new RunningHorseIterator($this);
    }

    public function getRunningHorse(int $key): RunningHorse
    {
        return $this->items[$key] ?? null;
    }

    public function addRunningHorse(RunningHorse $runningHorse)
    {
        $this->items[] = $runningHorse;
    }

    public function __isset($key): bool
    {
        return isset($this->items[$key]);
    }
}
