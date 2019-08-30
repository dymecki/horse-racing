<?php

declare(strict_types = 1);

namespace App\Domain\Model\Horse\Stats;

final class Time
{
    private $time;

    public function __construct(float $time)
    {
        if ($time < 0) {
            throw new \InvalidArgumentException('Time value cannot be negative');
        }

        $this->time = $time;
    }

//    public function subtract(float $delta): self
//    {
//        return new self($this->speed - self::BASE_SPEED - $delta);
//    }

    public function value(): float
    {
        return $this->time;
    }

    public function __toString()
    {
        return sprintf('%s s', $this->time);
    }
}
