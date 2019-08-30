<?php

declare(strict_types = 1);

namespace App\Domain\Model\Horse;

final class RunningHorse implements HorseInterface
{
    private $horse;

    public function __construct(Horse $horse)
    {
        $this->horse = $horse;
    }

    public function move(): void
    {
        $this->horse = new Horse(
            $this->horse->name(),
            $this->horse->speed(),
            $this->horse->strength(),
            $this->horse->endurance(),
            $this->horse->distance()->increaseBySpeed($this->speed())
        );
    }

    public function moveBySeconds(int $seconds)
    {
        $meters = 0;

        for ($i = 0; $i < $seconds; $i++) {
            
        }
    }

    public function isStillRunning(int $raceDistance): bool
    {
        return $this->horse->distance()->value() < $raceDistance;
    }

    public function strength(): Strength
    {
        return $this->horse->strength();
    }

    public function endurance(): Endurance
    {
        return $this->horse->endurance();
    }

    public function speed(): Speed
    {
        return $this->isSlowDown() ? $this->slowSpeed() : $this->horse->speed();
    }

    public function name(): Name
    {
        return $this->horse->name();
    }

    public function distance(): Distance
    {
        return $this->horse->distance();
    }

    private function slowSpeed(): Speed
    {
//        return new Speed($this->horse->speed()->value() - 5 * $this->horse->strength()->value() * 8 / 100);
        return $this->horse->speed()->subtract(5 * $this->horse->strength()->value() * 8 / 100);
    }

    private function isSlowDown(): bool
    {
        return $this->fullSpeedDistance()->isLess($this->horse->distance());
    }

    private function fullSpeedDistance(): Distance
    {
        return new Distance($this->horse->endurance()->value() * 100);
    }

    public function __toString()
    {
        return sprintf('%s - %s', $this->horse, $this->horse->distance());
    }
}
