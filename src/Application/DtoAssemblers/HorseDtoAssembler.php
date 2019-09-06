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

        $dto                    = new HorseDto();
        $dto->id                = $hr->horse()->id()->value();
        $dto->name              = $hr->horse()->name();
        $dto->speed             = (string) $hr->horse()->stats()->speed();
        $dto->strength          = (string) $hr->horse()->stats()->strength();
        $dto->endurance         = (string) $hr->horse()->stats()->endurance();
        $dto->distanceCovered   = $hr->stats()->distanceCovered()->value();
        $dto->time              = $hr->stats()->time()->formatted();
        $dto->position          = $hr->stats()->position()->value();
        $dto->fullSpeedDistance = $hr->fastDistance()->value();

        return $dto;
    }
}
