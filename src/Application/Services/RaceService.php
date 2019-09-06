<?php

declare(strict_types = 1);

namespace App\Application\Services;

use App\Domain\Model\Race\RaceFactory;
use App\Persistence\Dao\RaceDao;
use App\Application\DtoAssemblers\RaceDtoAssembler;
use App\Persistence\Dao\Mappers\RaceMapper;

final class RaceService
{
    const MAX_RACES_AMOUNT = 3;

    private $race;

    public function __construct()
    {
        $this->race  = new RaceDao();
    }

    public function canAddNewRace(): bool
    {
        return $this->race->countActiveRaces() < self::MAX_RACES_AMOUNT;
    }

    public function startNewRace(): void
    {
        if (!$this->canAddNewRace()) {
            return;
        }

        $this->race->addRace(RaceFactory::make());
    }

    public function activeRaces(): array
    {
        return $this->getDto($this->race->getActiveRaces());
    }

    public function getLastRacesBestPositions(): array
    {
        return $this->getDto($this->race->getLastRacesBestPositions());
    }

    public function updateRaces(): void
    {
        $activeRaces = $this->race->getActiveRaces();
        $races       = (new RaceMapper($activeRaces))->get();

        foreach ($races as $race) {
            $race->run(10);
        }

        foreach ($races as $race) {
            $this->race->updateRaceProgress($race);
        }
    }

    private function getDto(array $races): array
    {
        return array_map(function($race) {
            return (new RaceDtoAssembler($race))->writeDto();
        }, (new RaceMapper($races))->get());
    }
}
