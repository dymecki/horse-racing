<?php

declare(strict_types = 1);

namespace App\Application\DtoAssemblers;

use App\Domain\Model\Race\Race;
use App\Application\DtoAssemblers\Dto\RaceDto;

final class RaceDtoAssembler
{
    private $race;

    public function __construct(Race $race)
    {
        $this->race = $race;
    }

    public function writeDto(): RaceDto
    {
        $dto           = new RaceDto();
        $dto->id       = $this->race->id()->value();
        $dto->distance = $this->race->distance()->value();
        $dto->name     = substr($this->race->id()->value(), 0, 8);
        $dto->time     = $this->race->time()->value();

        foreach ($this->race->runningHorses() as $horse) {
            $horseDtoAssembler    = new HorseDtoAssembler($horse);
            $dto->runningHorses[] = $horseDtoAssembler->writeDto();
        }

        return $dto;
    }
}
