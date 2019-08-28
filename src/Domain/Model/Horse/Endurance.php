<?php

declare(strict_types = 1);

namespace App\Domain\Model\Horse;

final class Endurance
{
    private $endurance;

    public function __construct(float $endurance)
    {
        if ($endurance < 0 || $endurance > 10) {
            throw new InvalidArgumentException('Endurance value must be in range of 0.0 - 10.0');
        }

        $this->endurance = $endurance;
    }

    public function value(): float
    {
        return $this->endurance;
    }

    public function __toString()
    {
        return (string) $this->endurance;
    }
}
