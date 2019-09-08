<?php

declare(strict_types = 1);

namespace App\Domain\Model\Horse;

use App\Domain\Model\Race\HorseRun;
use App\Domain\Model\Race\Race;

interface HorseRepository
{
    public function add(Horse $horse): void;

    public function bestHorseRunEver(): HorseRun;

    public function updateHorseProgress(Race $race, HorseRun $horse): void;
}
