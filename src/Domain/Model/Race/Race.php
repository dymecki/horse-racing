<?php

declare(strict_types = 1);

namespace App\Domain\Model\Race;

final class Race
{
    const RACE_DISTANCE   = 1500;
    const ADVANCE_SECONDS = 10;

    private $horses;

    public function addHorse(RunningHorse $horse): void
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
                if (!$horse->isStillRunning(self::RACE_DISTANCE)) {
                    continue;
                }

                $horse->move();
            }
        }
    }

    public function isOver(): bool
    {
        foreach ($this->horses as $horse) {
            if ($horse->isStillRunning(self::RACE_DISTANCE)) {
                return false;
            }
        }

        return true;
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
