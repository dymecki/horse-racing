<?php

declare(strict_types = 1);

namespace App\Domain\Model\Race;

use App\Domain\Model\Horse\HorseFactory;

final class RaceFactory
{
    public static function make(): Race
    {
        $race = Race::init(1500);

        for ($i = 0; $i < 8; $i++) {
            $race->addHorseRun(HorseFactory::make());
        }

        return $race;
    }
}
