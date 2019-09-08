<?php

declare(strict_types=1);

namespace App\Application;

use App\Application\DtoAssemblers\Dto\HorseDto;
use App\Application\DtoAssemblers\HorseDtoAssembler;
use App\Domain\Model\Race\RaceFactory;
use App\Persistence\Repositories\DbHorseRepository;
use App\Persistence\Repositories\DbRaceRepository;
use App\Domain\Model\Race\RaceDtoIterator;

final class RaceService
{
    const MAX_RACES_AMOUNT = 3;

    private $race;

    public function __construct()
    {
        $this->race = new DbRaceRepository();
    }

    public function canAddNewRace(): bool
    {
        return $this->race->activeRacesAmount() < self::MAX_RACES_AMOUNT;
    }

    public function canProgress(): bool
    {
        return $this->race->activeRacesAmount() > 0;
    }

    public function startNewRace(): void
    {
        $this->canAddNewRace() ? $this->race->add(RaceFactory::make()) : null;
    }

    public function activeRaces(): RaceDtoIterator
    {
        return new RaceDtoIterator($this->race->activeRaces());
    }

    public function lastRacesBestPositions(): RaceDtoIterator
    {
        return new RaceDtoIterator($this->race->lastRacesBestPositions());
    }

    public function updateRaces(): void
    {
        $activeRaces = $this->race->activeRaces();

        foreach ($activeRaces as $race) {
            $race->run(10);
            $this->race->updateRaceProgress($race);
        }
    }

    public function bestHorseRunEver(): HorseDto
    {
        $horseRun = (new DbHorseRepository())->bestHorseRunEver();

        return $horseRun ? (new HorseDtoAssembler($horseRun))->dto() : new HorseDto();
    }
}
