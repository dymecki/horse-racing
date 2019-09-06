<?php

declare(strict_types = 1);

namespace App\Domain\Model\Race\Stats;

interface DistanceAlgorithm
{
    public function compute();
}
