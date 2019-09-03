<?php

declare(strict_types = 1);

namespace App\Application\Services;

use App\Persistence\Dao\HorseDao;
//use App\Domain\Model\Horse\HorseFactory;
use App\Domain\Model\Horse\HorseId;
use App\Domain\Model\Horse\Horse;
use App\Domain\Model\Race\HorseRun;
use App\Persistence\Dao\Mappers\HorseMapper;
use App\Application\DtoAssemblers\HorseDtoAssembler;
use App\Application\DtoAssemblers\Dto\HorseDto;

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

    public function getHorseRun(string $horseId): HorseRun
    {
        return $this->horse->getHorseRun(new HorseId($horseId));
    }

    public function getBestHorseRunEver()
    {
        return $this->getDto($this->horse->getBestHorseRunEver());
    }

    private function getDto($horse): HorseDto
    {
        if (!$horse) {
            return new HorseDto();
        }

        return (new HorseDtoAssembler((new HorseMapper($horse))->get()))->writeDto();
    }
}
