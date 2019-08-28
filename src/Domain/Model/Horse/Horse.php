<?php

declare(strict_types = 1);

namespace App\Domain\Model\Horse;

final class Horse implements HorseInterface
{
    private $name;
    private $speed;
    private $strength;
    private $endurance;
    private $distanceCovered;

    public function __construct(Name $name, Speed $speed, Strength $strength, Endurance $endurance, Distance $distanceCovered)
    {
        $this->name            = $name;
        $this->speed           = $speed;
        $this->strength        = $strength;
        $this->endurance       = $endurance;
        $this->distanceCovered = $distanceCovered;
    }

    public function speed(): Speed
    {
        return $this->speed;
    }

    public function slowSpeed(): Speed
    {
        return new Speed($this->speed->value() - 5 * $this->strength->value() * 8 / 100);
    }

    public function fullSpeedDistance(): Distance
    {
        return new Distance($this->endurance->value() * 100);
    }

    public function name(): Name
    {
        return $this->name;
    }

    public function __toString()
    {
        return (string) $this->name;
    }
}
