<?php

declare(strict_types = 1);

namespace App\Domain\Model\Race;

use App\Domain\Model\Horse\Horse;

final class RunningHorse implements HorseInterface
{
    private $horse;
    private $distanceCovered;

    public function __construct(Horse $horse, float $distanceCovered = 0)
    {
        $this->horse           = $horse;
        $this->distanceCovered = $distanceCovered;
    }

    public function move(): void
    {
        $this->distanceCovered += $this->isSlowDown() ? $this->horse->slowSpeed()->value() : $this->horse->speed()->value();
    }

    public function isStillRunning(int $distanceToRun): bool
    {
        return $this->distanceCovered < $distanceToRun;
    }

    public function isSlowDown(): bool
    {
        return $this->horse->fullSpeedDistance() - $this->distanceCovered < 0;
    }

    public function horse(): Horse
    {
        return $this->horse;
    }

    public function distanceCovered(): float
    {
        return $this->distanceCovered;
    }

    public function __toString()
    {
        return sprintf('%s - %s', $this->horse, $this->distanceCovered);
    }
}
