<?php

declare(strict_types = 1);

namespace App\Domain\Model\Race;

interface RaceRepository
{
    public function add(Race $race): void;

    public function activeRaces(): RaceCollection;

    public function updateRaceProgress(Race $race): void;

    public function activeRacesAmount(): int;

    public function lastRacesBestPositions(): RaceCollection;
}
