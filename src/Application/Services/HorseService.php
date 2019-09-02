<?php

declare(strict_types = 1);

namespace App\Application\Services;

use App\Persistence\Dao\HorseDao;
//use App\Domain\Model\Horse\HorseFactory;
use App\Domain\Model\Horse\HorseId;
use App\Domain\Model\Horse\Horse;
use App\Domain\Model\Race\RunningHorse;

final class HorseService
{
    private $horse;

    public function __construct()
    {
        $this->horse = new HorseDao();
    }

//    public function addNewHorse()
//    {
//        $horse = HorseFactory::make();
//
//        $this->horse->addHorse($horse);
//    }

    public function getAll(): array
    {
        return $this->horse->getAll();
    }

    public function getById(string $horseId): Horse
    {
        return $this->horse->getHorse(new HorseId($horseId));
    }

    public function getRuningHorse(string $horseId): RunningHorse
    {
        return $this->horse->getRunningHorse(new HorseId($horseId));
    }
}
