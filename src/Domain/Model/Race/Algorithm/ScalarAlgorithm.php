<?php

declare(strict_types = 1);

namespace App\Domain\Model\Race\Algorithm;

use App\Domain\Model\Race\HorseRun;
use App\Domain\Model\Horse\Stats\Time;
use App\Domain\Model\Horse\Stats\Speed;
use App\Domain\Model\Horse\Stats\Distance;

final class ScalarAlgorithm implements DistanceAlgorithm
{
    private $run;
    private $seconds;
    private $raceDistance;

    public function __construct(HorseRun $run, int $seconds, Distance $raceDistance)
    {
        $this->run          = $run;
        $this->seconds      = $seconds;
        $this->raceDistance = $raceDistance;
    }

    public function compute(): Speed
    {
        $raceDistance      = $this->raceDistance;
        $time              = $this->run->stats()->time()->value();
        $fullSpeedDistance = $this->fastDistance()->value();
        $slowSpeedDistance = $this->slowSpeed()->distance()->value();
        $fullSpeed         = $this->run->horse()->stats()->speed()->distance()->value();
        $fullSpeedSeconds  = $fullSpeedDistance / $fullSpeed;
        $forwardTime       = $time + $this->seconds;

        if ($forwardTime > $fullSpeedSeconds) {
            $coveredDistance = $fullSpeedDistance + ($forwardTime - $fullSpeedSeconds) * $slowSpeedDistance;
        }
        else {
            $coveredDistance = $forwardTime * $fullSpeed;
        }

        $time = $forwardTime;

        if ($coveredDistance > $raceDistance) {
            $time            -= $time * ($coveredDistance - $raceDistance) / $coveredDistance;
            $coveredDistance = $raceDistance;
        }

        return new Speed($coveredDistance, $time);
    }

    public function slowSpeed(): Speed
    {
        return $this->run->slowSpeed();
    }

    public function fastSpeed(): Speed
    {
        return $this->run->horse()->stats()->speed();
    }

    public function slowDistance(): Distance
    {
        return $this->slowSpeed()->distance();
    }

    public function fastDistance(): Distance
    {
//        return $this->fastSpeed()->distance();
        return $this->run->fastDistance();
    }
}
