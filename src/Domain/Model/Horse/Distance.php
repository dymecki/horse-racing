<?php

declare(strict_types = 1);

namespace App\Domain\Model\Horse;

final class Distance
{
    private $distance;

    public function __construct(float $distance)
    {
        if ($distance < 0) {
            throw new \InvalidArgumentException('Distance value cannot be negative');
        }

        $this->distance = $distance;
    }

    public function value(): float
    {
        return $this->distance;
    }

    public function __toString()
    {
        return sprintf('%s m', $this->distance);
    }
}
