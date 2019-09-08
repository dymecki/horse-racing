<?php

declare(strict_types = 1);

namespace App\Domain\Model\Race;

use App\Domain\Model\Horse\Horse;
use App\Domain\Model\Horse\Stats\Distance;
use App\Domain\Model\Horse\Stats\Speed;
use App\Domain\Model\Race\Stats\HorseRunStats;
use App\Domain\Model\Race\Algorithm\AlgorithmFactory;
use App\Domain\Model\Horse\Stats\Time;

final class HorseRun
{
    private $horse;
    private $stats;

    public function __construct(Horse $horse, HorseRunStats $stats)
    {
        $this->horse = $horse;
        $this->stats = $stats;
    }

    public function run(int $seconds, Distance $raceDistance): void
    {
        if ($this->isFinished($raceDistance)) {
            return;
        }

        $algorithm = AlgorithmFactory::obj($this, new Time($seconds), $raceDistance);
        $stats     = $algorithm->compute();

        $this->stats->update($stats);
    }

    public function isFinished(Distance $raceDistance): bool
    {
        return $this->stats->distanceCovered() === $raceDistance;
    }

    public function isStillGoing(Distance $raceDistance): bool
    {
        return $this->stats->distanceCovered() < $raceDistance;
    }

    public function horse(): Horse
    {
        return $this->horse;
    }

    public function stats(): HorseRunStats
    {
        return $this->stats;
    }

    public function fastDistance(): Distance
    {
        return $this->horse->stats()->endurance()->distance();
    }

    public function slowSpeed(): Speed
    {
        return $this->horse->stats()->speed()->slowedBy($this->slownessFactor());
    }

    private function slownessFactor(): float
    {
        return 5 * $this->horse->stats()->strength()->value() * 8 / 100;
    }
}
