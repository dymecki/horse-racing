<?php

declare(strict_types = 1);

namespace App\Domain\Model\Horse\Stats;

use App\Domain\Model\Horse\Stats\Speed;

final class Distance
{
    private $distance;

    public function __construct(float $distance = 0.0)
    {
        if ($distance < 0) {
            throw new \InvalidArgumentException('Distance value cannot be negative');
        }

        $this->distance = $distance;
    }

    public function cut(self $distance): self
    {
        return new self($this->distance - $distance->value());
    }

    public function ratio(self $distance): self
    {
        return new self($this->distance / $distance->value());
    }

    public function timeTaken(Speed $speed): Time
    {
        return new Time($this->distance / $speed->distance()->value());
    }

    public function isGreater(self $distance): bool
    {
        return $this->distance > $distance->value();
    }

    public function value(): float
    {
        return $this->distance;
    }

    public function extendedBy(Distance $distance): self
    {
        return new self($this->distance + $distance->value());
    }

    public function __toString()
    {
        return (string) $this->distance;
    }
}
