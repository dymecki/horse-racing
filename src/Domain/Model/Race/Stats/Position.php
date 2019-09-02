<?php

declare(strict_types = 1);

namespace App\Domain\Model\Race\Stats;

final class Position
{
    private $position;

    public function __construct(int $position = 0)
    {
        if ($position < 0) {
            throw new \InvalidArgumentException('Position value cannot be negative');
        }

        $this->position = $position;
    }

    public function value(): int
    {
        return $this->position;
    }

    public function __toString()
    {
        return (string) $this->position;
    }
}
