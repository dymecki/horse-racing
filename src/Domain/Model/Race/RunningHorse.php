<?php

declare(strict_types = 1);

namespace App\Domain\Model\Race;

use App\Domain\Model\Horse\Horse;
use App\Domain\Model\Horse\Stats\Distance;
use App\Domain\Model\Horse\Stats\Speed;
use App\Domain\Model\Race\Stats\RunningHorseStats;

final class RunningHorse
{
    const ENDURANCE_METERS = 100;

    private $horse;
    private $stats;

    public function __construct(Horse $horse, RunningHorseStats $stats)
    {
        $this->horse = $horse;
        $this->stats = $stats;
    }

    public static function create($data): self
    {
        return new self(
            Horse::create($data),
            RunningHorseStats::create((float) $data->distance_covered, $data->time)
        );
    }

    public function horse(): Horse
    {
        return $this->horse;
    }

    public function stats(): RunningHorseStats
    {
        return $this->stats;
    }

    public function move(): void
    {
        $this->stats->increaseDistance($this->speed()->distance());
        $this->stats->updateTime();
    }

//    public function moveByTime(): void
//    {
//        $this->stats->increaseTime($this->speed()->secondsPerMeter()->value());
//        $this->stats->increaseDistance(new Distance(1));
//    }

    public function speed(): Speed
    {
        return $this->isTired() ? $this->slowSpeed() : $this->horse->stats()->speed();
    }

    public function runForSeconds(int $seconds): void
    {
        $runDistance     = new Distance();
        $distanceCovered = $this->stats->distanceCovered();

        for ($i = 0; $i < $seconds; $i++) {
//            $delta       = $this->checkIfTired($runDistance) ? $this->slowSpeed()->distance() : $this->horse->stats()->speed()->distance();
            $delta           = $this->checkIfTired($distanceCovered) ? $this->slowSpeed()->distance() : $this->horse->stats()->speed()->distance();
            $runDistance     = $runDistance->withAdd($delta);
            $distanceCovered = $distanceCovered->withAdd($runDistance);
        }

        $this->stats->increase($runDistance, $seconds);
    }

    public function isStillRunning(int $raceDistance): bool
    {
        return $this->stats->distanceCovered()->value() < $raceDistance;
    }

    private function slowSpeed(): Speed
    {
        return $this->horse->stats()->speed()->subtract($this->slownessFactor());
    }

    private function slownessFactor(): float
    {
        return 5 * $this->horse->stats()->strength()->value() * 8 / 100;
    }

    private function checkIfTired(Distance $distance): bool
    {
        return $this->fullSpeedDistance()->isLessThan($distance);
    }

    private function isTired(): bool
    {
        return $this->checkIfTired($this->stats()->distanceCovered());
    }

    public function fullSpeedDistance(): Distance
    {
        return new Distance($this->horse->stats()->endurance()->value() * self::ENDURANCE_METERS);
    }
}
