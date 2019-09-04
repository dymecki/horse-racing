<?php

declare(strict_types = 1);

namespace App\Domain\Model\Horse\Stats;

final class HorseStats
{
    private $speed;
    private $strength;
    private $endurance;

    private function __construct(Speed $speed, Strength $strength, Endurance $endurance)
    {
        $this->speed     = $speed;
        $this->strength  = $strength;
        $this->endurance = $endurance;
    }

    public static function create(float $speed, float $strength, float $endurance): self
    {
        return new self(
            Speed::init($speed),
            new Strength($strength),
            new Endurance($endurance)
        );
    }

    public function speed(): Speed
    {
        return $this->speed;
    }

    public function strength(): Strength
    {
        return $this->strength;
    }

    public function endurance(): Endurance
    {
        return $this->endurance;
    }
}
