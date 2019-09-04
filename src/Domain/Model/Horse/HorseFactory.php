<?php

declare(strict_types = 1);

namespace App\Domain\Model\Horse;

use App\Domain\Model\Horse\Stats\HorseStats;
use App\Domain\Model\Race\HorseRun;
use App\Domain\Model\Race\Stats\HorseRunStats;

final class HorseFactory
{
    public static function make(): HorseRun
    {
        $horse = new Horse(
            HorseId::init(),
            HorseStats::create(
                rand(0, 10) / 10,
                rand(0, 10) / 10,
                rand(0, 10) / 10
            )
        );

        return new HorseRun($horse, HorseRunStats::create());
    }
}
