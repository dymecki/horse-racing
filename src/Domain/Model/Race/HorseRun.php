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
                $data->time,
                $data->horse_position ?? 0
            )
        );
    }

    public function horse(): Horse
    {
        return $this->horse;
    }

    public function stats(): HorseRunStats
    {
        return $this->stats;
    }

    // TODO: metoda nieużywana
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

    public function runForSeconds(int $seconds, int $raceDistance = 1500): void
    {
        $this->distanceAlgorithm($seconds, $raceDistance);
//        exit;
//
//        $tmpDistance     = new Distance();
//        $distanceCovered = $this->stats->distanceCovered();
//
////        for ($i = 0; $i < $seconds; $i++) {
////            $oneSecondDistance = $this->checkIfTired($distanceCovered) ? $this->slowSpeed()->distance() : $this->horse->stats()->speed()->distance();
////            $tmpDistance       = $tmpDistance->withAdd($oneSecondDistance);
////            $distanceCovered   = $distanceCovered->withAdd($oneSecondDistance);
////
////            if ($distanceCovered->value() >= $raceDistance) {
////                break;
////            }
////        }
//        // =====================
//
//        $counter = 0;
//
//        while ($counter < $seconds && $distanceCovered->value() < $raceDistance) {
//            $oneSecondDistance = $this->checkIfTired($distanceCovered) ? $this->slowSpeed()->distance() : $this->horse->stats()->speed()->distance();
//            $tmpDistance       = $tmpDistance->withAdd($oneSecondDistance);
//            $distanceCovered   = $distanceCovered->withAdd($oneSecondDistance);
//
//            $counter++;
//        }
//
//        $this->stats->increase($tmpDistance, $seconds);
    }

    public function distanceAlgorithm($seconds = 10, int $maxDistance = 1500)
    {
        $time              = $this->stats->time()->value();
        $fullSpeedDistance = $this->fullSpeedDistance()->value();
        $fullSpeed         = $this->horse->stats()->speed()->time()->value();
        $fullSpeedSeconds  = $fullSpeedDistance / $fullSpeed;
        $forwardTime       = $time + $seconds;

        if ($forwardTime > $fullSpeedSeconds) {
            $slowSpeedTime    = $forwardTime - $fullSpeedSeconds;
            $slowPartDistance = $slowSpeedTime * $this->slowSpeed()->distance()->value();
            $coveredDistance  = $fullSpeedDistance + $slowPartDistance;
//            $coveredDistance = $fullSpeedDistance + ($forwardTime - $fullSpeedSeconds) * $this->slowSpeed()->distance()->value();
        }
        else {
            $coveredDistance = $forwardTime * $fullSpeed;
        }

        $time = $forwardTime;

        if ($coveredDistance > $maxDistance) {
            $diff            = $coveredDistance - $maxDistance;
            $ratio           = $diff / $coveredDistance;
            $coveredDistance = $maxDistance;
            $time            = $time - $time * $ratio;
        }

        $this->stats->update(new Distance($coveredDistance), $time);
    }

    public function isStillGoing(Distance $raceDistance): bool
    {
        return $this->stats->distanceCovered() < $raceDistance;
    }

    private function slowSpeed(): Speed
    {
        return $this->horse->stats()->speed()->subtract($this->slownessFactor());
    }

    private function slownessFactor(): float
    {
        return 5 * $this->horse->stats()->strength()->value() * 8 / 100;
    }

    private function checkIfTired(Distance $distanceCovered): bool
    {
        return $distanceCovered > $this->fullSpeedDistance();
    }

    public function isTired(): bool
    {
        return $this->checkIfTired($this->stats()->distanceCovered());
    }

    public function fullSpeedDistance(): Distance
    {
        return new Distance($this->horse->stats()->endurance()->value() * self::ENDURANCE_METERS);
    }
}
