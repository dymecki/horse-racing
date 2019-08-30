<?php

declare(strict_types = 1);

namespace App\Domain\Model\Horse;

final class Speed
{
    const BASE_SPEED = 5.0;

    private $speed;

    public function __construct(float $speed)
    {
        if ($speed < 0 || $speed > 10) {
            throw new \InvalidArgumentException('Speed value must be in range of 0.0 - 10.0');
        }

        $this->speed = self::BASE_SPEED + $speed;
    }

    public function value(): float
    {
        return $this->speed;
    }

//    public function slowSpeedValue(Strength $strength): float
//    {
//        return $this->speed - 5 * $strength->value() * 8 / 100;
//    }

    public function __toString()
    {
        return sprintf('%s m/s', $this->speed);
    }
}