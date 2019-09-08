<?php

declare(strict_types = 1);

namespace App\Domain\Model\Race;

final class RaceCollection implements \IteratorAggregate, \Countable
{
    /** @var Race[] */
    private $items;

    private function __construct(Race ...$items)
    {
        $this->items = $items;
    }

    public static function obj(array $items = []): self
    {
        return new self(...$items);
    }

    public function getIterator(): RaceIterator
    {
        return new RaceIterator($this);
    }

    public function get(int $key): ?Race
    {
        return $this->items[$key] ?? null;
    }

    public function add(Race $race): void
    {
        $this->items[] = $race;
    }

    public function last(): ?Race
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
