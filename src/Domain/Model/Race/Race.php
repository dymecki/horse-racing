<?php

declare(strict_types = 1);

namespace App\Domain\Model\Race;

use App\Domain\Model\Horse\HorseInterface;
use App\Domain\Model\Horse\Stats\Distance;
use App\Domain\Model\Race\RaceId;
use App\Domain\Model\Horse\Stats\Seconds;

final class Race
{
    const ADVANCE_SECONDS = 10;

    private $id;
    private $horses;
    private $distance;

    private function __construct(RaceId $id, Distance $distance, $horses)
    {
        $this->id       = $id;
        $this->distance = $distance;
        $this->horses   = $horses;
    }

    public static function init(int $distance): self
    {
        return new self(RaceId::init(), new Distance($distance), []);
    }

    public static function create($id, int $distance, $horses): self
    {
        return new self(
            new RaceId($id),
            new Distance($distance),
            $horses
        );
    }

//    public static function fromStd($data): self
//    {
//        var_dump($data);
//        return new self(
//            RaceId::init(),
//            new Distance($data->distance),
//            $data
//        );
//    }

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

    public function runForSeconds(int $seconds): void
    {
        foreach ($this->horses as $horse) {
            $horse->runForSeconds($seconds);
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
        return $horse->stats()->distanceCovered()->isLess($this->distance);
    }

    public function time(): Seconds
    {
        return isset($this->horses[0]) ? $this->horses[0]->stats()->time() : new Seconds(0);
    }

    public function id(): RaceId
    {
        return $this->id;
    }

    public function horses(): array
    {
        return $this->horses;
    }

    public function distance(): Distance
    {
        return $this->distance;
    }
}
