<?php

declare(strict_types = 1);

namespace App\Domain\Model\Horse;

use App\Domain\Model\Horse\Stats\HorseStats;
use App\Domain\Model\Race\RunningHorse;
use App\Domain\Model\Race\Stats\RunningHorseStats;

final class HorseFactory
{
    public static function make(): RunningHorse
    {
        $horse = new Horse(
            HorseId::init(),
            HorseStats::create(
                rand(0, 10) / 10,
                rand(0, 10) / 10,
                rand(0, 10) / 10
            )
        );

        return new RunningHorse($horse, RunningHorseStats::start());
    }
}
