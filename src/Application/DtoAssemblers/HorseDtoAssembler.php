<?php

declare(strict_types = 1);

namespace App\Application\DtoAssemblers;

use App\Domain\Model\Race\RunningHorse;
use App\Application\DtoAssemblers\Dto\HorseDto;

final class HorseDtoAssembler
{
    private $runningHorse;

    public function __construct(RunningHorse $runningHorse)
    {
        $this->runningHorse = $runningHorse;
    }

    public function writeDto(): HorseDto
    {
        $rh = $this->runningHorse;

        $dto                  = new HorseDto();
        $dto->id              = $rh->horse()->id()->value();
        $dto->name            = $rh->horse()->name();
        $dto->speed           = $rh->horse()->stats()->speed()->distance()->value();
        $dto->strength        = $rh->horse()->stats()->strength()->value();
        $dto->endurance       = $rh->horse()->stats()->endurance()->value();
        $dto->distanceCovered = $rh->stats()->distanceCovered()->value();
        $dto->time            = $rh->stats()->time()->value();
        $dto->position        = $rh->stats()->position()->value();

        return $dto;
    }
}
