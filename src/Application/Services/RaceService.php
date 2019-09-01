<?php

declare(strict_types = 1);

namespace App\Application\Services;

use App\Domain\Model\Race\Race;
use App\Domain\Model\Race\RaceFactory;
use App\Persistence\Dao\RaceDao;
use App\Persistence\Dao\HorseDao;

final class RaceService
{
    const MAX_RACES_AMOUNT = 3;

    private $race;
    private $horse;

    public function __construct()
    {
        $this->race  = new RaceDao();
        $this->horse = new HorseDao();
    }

    public function getById(string $raceId)
    {
        return $this->race->getById($raceId);
    }

    public function getRaceHorses(string $raceId)
    {
        return $this->race->getRaceHorses($raceId);
    }

    public function startNewRace()
    {
        $activeRaces = $this->race->countActiveRaces();

        if ($activeRaces >= self::MAX_RACES_AMOUNT) {
            return false;
        }

        $race   = RaceFactory::make();
        $horses = $race->horses();

        $this->race->addRace($race);

        foreach ($horses as $horse) {
            $this->horse->addHorse($horse);
        }
    }

    public function moveAllHorses()
    {
        
    }

    public function activeRaces()
    {
        return $this->race->getActiveRaces();
    }

    public function getAllRaces()
    {
        return $this->race->getAll();
    }

    public function updateRaces($races)
    {
        foreach ($races as $race) {
            $this->race->updateRaceProgress($race);
        }
    }
}
