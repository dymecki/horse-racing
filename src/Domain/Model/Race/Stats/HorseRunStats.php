<?php

declare(strict_types = 1);

namespace App\Domain\Model\Race\Stats;

use App\Domain\Model\Horse\Stats\Distance;
use App\Domain\Model\Horse\Stats\Time;

final class HorseRunStats
{
    private $distanceCovered;
    private $time;
    private $position;

    private function __construct(Distance $distance, Time $time, Position $position)
    {
        $this->distanceCovered = $distance;
        $this->time            = $time;
        $this->position        = $position;
    }

    public static function create(float $distance = 0.0, float $time = 0.0, int $position = 0): self
    {
        return new self(
            new Distance($distance),
            new Time($time),
            new Position($position)
        );
    }

    public function update(Distance $distance, float $seconds): void
    {
        $this->distanceCovered = $distance;
        $this->time            = new Time($seconds);
    }

    public function distanceCovered(): Distance
    {
        return $this->distanceCovered;
    }

    public function time(): Time
    {
        return $this->time;
    }

    public function position(): Position
    {
        return $this->position;
    }
}
