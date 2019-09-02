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

    private function __construct(RaceId $id, Distance $distance, array $horses)
    {
        $this->id       = $id;
        $this->distance = $distance;
        $this->horses   = $horses;
    }

    public static function init(int $distance): self
    {
        return new self(RaceId::init(), new Distance($distance), []);
    }

    public static function create(string $id, int $distance, $horses): self
    {
        return new self(
            new RaceId($id),
            new Distance($distance),
            $horses
        );
    }

    public function addRunningHorse(RunningHorse $horse): void
    {
        $this->horses[] = $horse;
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
        return $horse->stats()->distanceCovered()->isLessThan($this->distance);
    }

    public function time(): Seconds
    {
        return isset($this->horses[0]) ? $this->horses[0]->stats()->time() : new Seconds(0);
    }

    public function id(): RaceId
    {
        return $this->id;
    }

    public function runningHorses(): array
    {
        return $this->horses;
    }

    public function distance(): Distance
    {
        return $this->distance;
    }
}
