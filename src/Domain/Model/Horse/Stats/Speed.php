<?php

declare(strict_types = 1);

namespace App\Domain\Model\Horse\Stats;

final class Speed
{
    const BASE_SPEED = 5.0;

    private $distance;
    private $time;

    private function __construct(Distance $distance, Seconds $time)
    {
        $this->distance = $distance;
        $this->time     = $time;
    }

    public static function init(float $distance): self
    {
        return new self(
            new Distance($distance),
            new Seconds(1)
        );
    }

    public function subtract(float $delta): self
    {
        return new self(
            new Distance($this->distance->value() - self::BASE_SPEED - $delta),
            $this->time
        );
    }

    public function secondsPerMeter(): Seconds
    {
        return new Seconds($this->time->value() / $this->distance->value());
    }

    public function distance(): Distance
    {
        return $this->distance;
    }

    public function time(): Seconds
    {
        return $this->time;
    }

    public function __toString()
    {
        return sprintf('%s / %s', $this->distance, $this->time);
    }
}
