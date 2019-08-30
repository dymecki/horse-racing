<?php

declare(strict_types = 1);

namespace App\Domain\Model\Horse;

use App\Domain\Model\Horse\RunningHorse;

final class HorseFactory
{
    public static function make(): RunningHorse
    {
        $horse = new Horse(
            new Name('Secretariat_' . rand(0, 100)),
            new Speed(rand(0, 10)),
            new Strength(rand(0, 10)),
            new Endurance(rand(0, 10)),
            new Distance()
        );

        return new RunningHorse($horse);
    }
}
