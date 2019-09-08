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

    public function dto(): RaceDto
    {
        $dto           = new RaceDto();
        $dto->id       = $this->race->id()->value();
        $dto->distance = $this->race->distance()->value();
        $dto->name     = $this->race->name();
        $dto->time     = $this->race->time()->formatted();

        foreach ($this->race->horseRuns() as $horse) {
            $dto->horseRuns[] = (new HorseDtoAssembler($horse))->dto();
        }

        return $dto;
    }
}
