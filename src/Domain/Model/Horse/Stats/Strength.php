<?php

declare(strict_types = 1);

namespace App\Domain\Model\Horse\Stats;

final class Strength
{
    private $strength;

    public function __construct(float $strength)
    {
        if ($strength < 0 || $strength > 10) {
            throw new \InvalidArgumentException('Strength value must be in range of 0.0 - 10.0');
        }

        $this->strength = $strength;
    }

    public function value(): float
    {
        return $this->strength;
    }

    public function __toString()
    {
        return number_format($this->strength, 1);
    }
}
