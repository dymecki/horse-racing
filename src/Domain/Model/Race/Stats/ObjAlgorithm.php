<?php

declare(strict_types = 1);

namespace App\Domain\Model\Race\Stats;

use App\Domain\Model\Race\HorseRun;
use App\Domain\Model\Horse\Stats\Time;
use App\Domain\Model\Horse\Stats\Speed;
use App\Domain\Model\Horse\Stats\Distance;

final class ObjAlgorithm implements DistanceAlgorithm
{
    private $run;
    private $seconds;
    private $raceDistance;

    public function __construct(HorseRun $run, int $seconds, Distance $raceDistance)
    {
        $this->run          = $run;
        $this->seconds      = new Time($seconds);
        $this->raceDistance = $raceDistance;
    }

    public function compute()
    {
        $raceDistance  = $this->raceDistance;
        $coveredTime   = $this->run->stats()->time();
        $fastTime      = $this->fastDistance()->timeTaken($this->fastSpeed());
        $forwardedTime = $coveredTime->forwardedBy($this->seconds);

        if ($forwardedTime->greater($fastTime)) {
            $slowTime        = $forwardedTime->cut($fastTime);
            $slowDistance    = $this->run->slowSpeed()->distanceAfter($slowTime);
            $coveredDistance = $this->fastDistance()->extendedBy($slowDistance);
        }
        else {
            $coveredDistance = $this->fastSpeed()->distanceAfter($forwardedTime);
        }

        if ($coveredDistance->isGreater($raceDistance)) {
            $forwardedTime   = $forwardedTime->cut(new Time($forwardedTime->value() * $coveredDistance->cut($raceDistance)->ratio($coveredDistance)->value()));
            $coveredDistance = $raceDistance;
        }

        return [$coveredDistance->value(), $forwardedTime->value()];

//        $coveredTime = $forwardedTime;
//
//        if ($coveredDistance->isGreater($raceDistance)) {
//            $coveredTime     = $coveredTime->cut(new Time($coveredTime->value() * $coveredDistance->cut($raceDistance)->ratio($coveredDistance)->value()));
//            $coveredDistance = $raceDistance;
//        }
//
//        return [$coveredDistance->value(), $coveredTime->value()];
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
