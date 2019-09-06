<?php

declare(strict_types = 1);

namespace App\Domain\Model\Race\Algorithm;

use App\Domain\Model\Race\HorseRun;
use App\Domain\Model\Horse\Stats\Time;
use App\Domain\Model\Horse\Stats\Distance;

final class AlgorithmFactory
{
    public static function obj(HorseRun $run, Time $time, Distance $raceDistance): DistanceAlgorithm
    {
//        return new ScalarAlgorithm($run, $time, $raceDistance);
        return new ObjAlgorithm($run, $time, $raceDistance);
    }
}
