<?php

declare(strict_types = 1);

namespace App\Domain\Model\Race\Algorithm;

use App\Domain\Model\Race\HorseRun;
use App\Domain\Model\Horse\Stats\Time;
use App\Domain\Model\Horse\Stats\Speed;
use App\Domain\Model\Horse\Stats\Distance;
use App\Domain\Model\Race\Algorithm\DistanceAlgorithm;

final class ObjAlgorithm implements DistanceAlgorithm
{
    private $run;
    private $seconds;
    private $raceDistance;

    public function __construct(HorseRun $run, Time $seconds, Distance $raceDistance)
    {
        $this->run          = $run;
        $this->seconds      = $seconds;
        $this->raceDistance = $raceDistance;
    }

    public function compute(): Speed
    {
        $raceDistance  = $this->raceDistance;
        $coveredTime   = $this->run->stats()->time();
        $fastTime      = $this->fastDistance()->timeTaken($this->fastSpeed());
        $forwardedTime = $coveredTime->forwardedBy($this->seconds);

        if ($forwardedTime->isGreater($fastTime)) {
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

        return new Speed($coveredDistance, $forwardedTime);
    }

    public function fastSpeed(): Speed
    {
        return $this->run->horse()->stats()->speed();
    }

    public function fastDistance(): Distance
    {
        return $this->run->fastDistance();
    }
}
