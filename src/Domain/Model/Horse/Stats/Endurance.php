<?php

declare(strict_types = 1);

namespace App\Domain\Model\Horse\Stats;

final class Endurance
{
    const FULL_SPEED_METERS = 100;

    private $endurance;

    public function __construct(float $endurance)
    {
        if ($endurance < 0 || $endurance > 10) {
            throw new \InvalidArgumentException('Endurance value must be in range of 0.0 - 10.0');
        }

        $this->endurance = $endurance;
    }

    public function distance(): Distance
    {
        return new Distance($this->endurance * self::FULL_SPEED_METERS);
    }

    public function value(): float
    {
        return $this->endurance;
    }

    public function __toString()
    {
        return number_format($this->endurance, 1);
    }
}
