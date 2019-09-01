<?php

declare(strict_types = 1);

namespace App\Domain\Model\Race\Stats;

use App\Domain\Model\Horse\Stats\Distance;
use App\Domain\Model\Horse\Stats\Seconds;

final class RunningHorseStats
{
    private $distanceCovered;
    private $time;

    private function __construct(Distance $distance, Seconds $time)
    {
        $this->distanceCovered = $distance;
        $this->time            = $time;
    }

    public static function create(float $distance = 0, float $time = 0): self
    {
        return new self(
            new Distance($distance),
            new Seconds($time)
        );
    }

    public static function start(): self
    {
        return self::create();
    }

    public function increase(Distance $distance, float $seconds): void
    {
        $this->increaseDistance($distance);
        $this->increaseTime($seconds);
    }

    public function increaseTime(float $seconds): void
    {
        $this->time = $this->time->withAdd($seconds);
    }

    public function updateTime(): void
    {
        $this->increaseTime(1);
//        $this->time = $this->time->withAdd(1);
    }

    public function increaseDistance(Distance $distance): void
    {
        $this->distanceCovered = $this->distanceCovered->withAdd($distance);
    }

    public function distanceCovered(): Distance
    {
        return $this->distanceCovered;
    }

    public function time(): Seconds
    {
        return $this->time;
    }
}
