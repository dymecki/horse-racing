<?php

declare(strict_types = 1);

namespace App\Domain\Model\Horse\Stats;

final class Speed
{
    const BASE_SPEED = 5.0;

    private $distance;
    private $time;

    public function __construct(Distance $distance, Time $time)
    {
        $this->distance = $distance;
        $this->time     = $time;
    }

    public static function obj(float $distance): self
    {
        if ($distance < 0 || $distance > 10) {
            throw new \InvalidArgumentException('Speed value must be in range of 0.0 - 10.0');
        }

        return new self(
            new Distance($distance + self::BASE_SPEED),
            new Time(1)
        );
    }

    public function slowedBy(float $delta): self
    {
        return new self(
            new Distance($this->distance->value() - $delta),
            $this->time
        );
    }

    public function distanceAfter(Time $time): Distance
    {
        return new Distance($this->distance->value() * $time->value());
    }

    public function distance(): Distance
    {
        return $this->distance;
    }

    public function time(): Time
    {
        return $this->time;
    }

    public function __toString()
    {
        return number_format($this->distance->value() - self::BASE_SPEED, 1);
    }
}
