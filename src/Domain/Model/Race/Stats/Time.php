<?php

declare(strict_types = 1);

namespace App\Domain\Model\Race\Stats;

final class Time
{
    private $time;

    public function __construct(float $time = 1)
    {
        if ($time < 0) {
            throw new \InvalidArgumentException('Time value cannot be negative');
        }

        $this->time = $time;
    }

    public function value(): float
    {
        return $this->time;
    }

    public function __toString()
    {
        return sprintf('%s s', $this->time);
    }
}
