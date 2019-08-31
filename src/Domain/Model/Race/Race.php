<?php

declare(strict_types = 1);

namespace App\Domain\Model\Race;

use App\Domain\Model\Horse\HorseInterface;
use App\Domain\Model\Horse\Stats\Distance;

final class Race
{
    const ADVANCE_SECONDS = 10;

    private $horses;
    private $distance;

    private function __construct(Distance $distance)
    {
        $this->distance = $distance;
    }

    public static function init(int $distance): self
    {
        return new self(new Distance($distance));
    }

    public function addRunningHorse(RunningHorse $horse): void
    {
        $this->horses[] = $horse;
    }

//    public function run()
//    {
//        foreach ($this->horses as $horse) {
//            if (!$horse->isStillRunning(self::RACE_DISTANCE)) {
//                continue;
//            }
//
//            $horse->move();
//        }
//    }

    public function moveHorses()
    {
        for ($i = 0; $i < self::ADVANCE_SECONDS; $i++) {
            foreach ($this->horses as $horse) {
                if (!$this->isStillRunning($horse)) {
                    continue;
                }

                $horse->move();
            }
        }
    }

    public function isOver(): bool
    {
        foreach ($this->horses as $horse) {
            if ($this->isStillRunning($horse)) {
                return false;
            }
        }

        return true;
    }

    public function isStillRunning(RunningHorse $horse): bool
    {
        return $horse->stats()->distance()->isLess($this->distance);
    }

    public function horses(): array
    {
        return $this->horses;
    }

    public function distance(): int
    {
        return $this->distance;
    }
}
