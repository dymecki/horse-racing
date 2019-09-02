<?php

declare(strict_types = 1);

namespace App\Application\DtoAssemblers;

use App\Domain\Model\Race\HorseRun;
use App\Application\DtoAssemblers\Dto\HorseDto;

final class HorseDtoAssembler
{
    private $horseRun;

    public function __construct(HorseRun $horseRun)
    {
        $this->horseRun = $horseRun;
    }

    public function writeDto(): HorseDto
    {
        $hr = $this->horseRun;

        $dto                  = new HorseDto();
        $dto->id              = $hr->horse()->id()->value();
        $dto->name            = $hr->horse()->name();
        $dto->speed           = $hr->horse()->stats()->speed()->distance()->value();
        $dto->strength        = $hr->horse()->stats()->strength()->value();
        $dto->endurance       = $hr->horse()->stats()->endurance()->value();
        $dto->distanceCovered = $hr->stats()->distanceCovered()->value();
        $dto->time            = $hr->stats()->time()->value();
        $dto->position        = $hr->stats()->position()->value();

        return $dto;
    }
}
