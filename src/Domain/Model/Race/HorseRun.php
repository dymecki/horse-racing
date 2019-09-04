<?php

declare(strict_types = 1);

namespace App\Domain\Model\Race;

use App\Domain\Model\Horse\Horse;
use App\Domain\Model\Horse\Stats\Distance;
use App\Domain\Model\Horse\Stats\Speed;
use App\Domain\Model\Race\Stats\HorseRunStats;

final class HorseRun
{
    const ENDURANCE_METERS = 100;

    private $horse;
    private $stats;

    public function __construct(Horse $horse, HorseRunStats $stats)
    {
        $this->horse = $horse;
        $this->stats = $stats;
    }

    public static function create($data): self
    {
        return new self(
            Horse::create($data),
            HorseRunStats::create(
                (float) $data->distance_covered,
                (float) $data->time,
                $data->horse_position ?? 0
            )
        );
    }

    public function runForSeconds(int $seconds, int $raceDistance = 1500): void
    {
        $time              = $this->stats->time()->value();
        $fullSpeedDistance = $this->fullSpeedDistance()->value();
        $slowSpeedDistance = $this->slowSpeed()->distance()->value();
        $fullSpeed         = $this->horse->stats()->speed()->time()->value();
        $fullSpeedSeconds  = $fullSpeedDistance / $fullSpeed;
        $forwardTime       = $time + $seconds;

        $coveredDistance = $forwardTime > $fullSpeedSeconds 
            ? $fullSpeedDistance + ($forwardTime - $fullSpeedSeconds) * $slowSpeedDistance
            : $forwardTime * $fullSpeed;

        $time = $forwardTime;

        if ($coveredDistance > $maxDistance) {
            $time            -= $time * ($coveredDistance - $maxDistance) / $coveredDistance;
            $coveredDistance = $maxDistance;
        }

        $this->stats->update(new Distance($coveredDistance), $time);
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

    private function fullSpeedDistance(): Distance
    {
        return new Distance($this->horse->stats()->endurance()->value() * self::ENDURANCE_METERS);
    }

    private function slowSpeed(): Speed
    {
        return $this->horse->stats()->speed()->subtract($this->slownessFactor());
    }

    private function slownessFactor(): float
    {
        return 5 * $this->horse->stats()->strength()->value() * 8 / 100;
    }
}
