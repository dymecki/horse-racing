<?php

declare(strict_types = 1);

namespace App\Domain\Model\Race;

use App\Domain\Model\Horse\Horse;
use App\Domain\Model\Horse\Stats\Distance;
use App\Domain\Model\Horse\Stats\Speed;
use App\Domain\Model\Race\Stats\HorseRunStats;
use App\Domain\Model\Race\Stats\ObjAlgorithm;
use App\Domain\Model\Race\Stats\ScalarAlgorithm;

final class HorseRun
{
    private $horse;
    private $stats;

    public function __construct(Horse $horse, HorseRunStats $stats)
    {
        $this->horse = $horse;
        $this->stats = $stats;
    }

    public static function obj($data): self
    {
        return new self(
            Horse::obj($data),
            HorseRunStats::obj(
                (float) $data->distance_covered,
                (float) $data->time,
                $data->horse_position ?? 0
            )
        );
    }

    public function runForSeconds(int $seconds, Distance $raceDistance): void
    {
        if (!$this->isStillGoing($raceDistance)) {
            return;
        }

//        $result = (new ScalarAlgorithm($this, $seconds, $raceDistance))->compute();
        $result = (new ObjAlgorithm($this, $seconds, $raceDistance))->compute();

        $this->stats->update(new Distance($result[0]), $result[1]);
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
