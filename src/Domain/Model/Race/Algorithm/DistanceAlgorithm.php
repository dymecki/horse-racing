<?php

declare(strict_types = 1);

namespace App\Domain\Model\Race\Algorithm;

use App\Domain\Model\Horse\Stats\Speed;

interface DistanceAlgorithm
{
    public function compute(): Speed;
}
