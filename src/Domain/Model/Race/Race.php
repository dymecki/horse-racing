<?php

declare(strict_types = 1);

namespace App\Domain\Model\Race;

use App\Domain\Model\Horse\HorseInterface;

final class Race
{
    const RACE_DISTANCE   = 1500;
    const ADVANCE_SECONDS = 10;

    private $horses;

    public function addHorse(HorseInterface $horse): void
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

    public function isStillRunning(HorseInterface $horse): bool
    {
        return $horse->distance()->value() < self::RACE_DISTANCE;
    }

    public function horses(): array
    {
        return $this->horses;
    }

    public function distance(): int
    {
        return self::RACE_DISTANCE;
    }
}
