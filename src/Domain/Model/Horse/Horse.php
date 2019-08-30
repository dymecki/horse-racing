<?php

declare(strict_types = 1);

namespace App\Domain\Model\Horse;

final class Horse implements HorseInterface
{
    private $name;
    private $speed;
    private $strength;
    private $endurance;
    private $distance;

    public function __construct(
        Name $name,
        Speed $speed,
        Strength $strength,
        Endurance $endurance,
        Distance $distance
    )
    {
        $this->name      = $name;
        $this->speed     = $speed;
        $this->strength  = $strength;
        $this->endurance = $endurance;
        $this->distance  = $distance;
    }

    public function speed(): Speed
    {
        return $this->speed;
    }

    public function name(): Name
    {
        return $this->name;
    }

    public function strength(): Strength
    {
        return $this->strength;
    }

    public function endurance(): Endurance
    {
        return $this->endurance;
    }

    public function distance(): Distance
    {
        return $this->distance;
    }

    public function move(): void
    {
        $this->distance = $this->distance->increaseBySpeed($this->speed());
    }

    public function __toString()
    {
        return sprintf('%s Speed: %s, Strength: %s', $this->name, $this->speed, $this->strength);
    }
}
