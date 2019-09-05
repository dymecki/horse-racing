<?php

declare(strict_types = 1);

namespace App\Domain\Model\Race;

use App\Domain\Model\Horse\Stats\Distance;
use App\Domain\Model\Race\RaceId;
use App\Domain\Model\Horse\Stats\Time;
use App\Domain\Model\Horse\HorseRunCollection;

final class Race
{
    const ADVANCE_SECONDS = 10;

    private $id;
    private $horseRuns;
    private $distance;

    private function __construct(RaceId $id, Distance $distance, HorseRunCollection $horseRuns)
    {
        $this->id        = $id;
        $this->distance  = $distance;
        $this->horseRuns = $horseRuns;
    }

    public static function init(int $distance = 1500): self
    {
        return new self(
            RaceId::init(),
            new Distance($distance),
            new HorseRunCollection()
        );
    }

    public static function create(string $id, int $distance, array $horseRuns = []): self
    {
        return new self(
            new RaceId($id),
            new Distance($distance),
            new HorseRunCollection($horseRuns)
        );
    }

    public function addHorseRun(HorseRun $horseRun): void
    {
        $this->horseRuns->addHorseRun($horseRun);
    }

    public function runForSeconds(int $seconds): void
    {
        foreach ($this->horseRuns as $horseRun) {
            if (!$horseRun->isStillGoing($this->distance)) {
                continue;
            }

            $horseRun->runForSeconds($seconds);
        }
    }

    public function time(): Time
    {
        return $this->horseRuns->isEmpty() ? new Time() : $this->horseRuns->first()->stats()->time();
    }

    public function id(): RaceId
    {
        return $this->id;
    }

    public function horseRuns(): HorseRunCollection
    {
        return $this->horseRuns;
    }

    public function distance(): Distance
    {
        return $this->distance;
    }

    public function name(): string
    {
        return substr((string) $this->id, 0, 8);
    }
}
