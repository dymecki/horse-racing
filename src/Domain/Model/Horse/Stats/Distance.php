<?php

declare(strict_types = 1);

namespace App\Domain\Model\Horse\Stats;

final class Distance
{
    private $distance;

    public function __construct(float $distance = 0.0)
    {
//        if ($distance < 0) {
//            throw new \InvalidArgumentException('Distance value cannot be negative');
//        }

        $this->distance = $distance;
    }

    public function value(): float
    {
        return $this->distance;
    }

    public function increaseBySpeed(Speed $speed): self
    {
        return new self($this->distance + $speed->distance()->value());
    }

    public function withAdd(Distance $distance): self
    {
        return new self($this->distance + $distance->value());
    }

    public function isLessThan(self $distance): bool
    {
        return $this->distance < $distance->value();
    }

    public function __toString()
    {
        return (string) $this->distance;
    }
}
