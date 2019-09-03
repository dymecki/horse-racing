<?php

declare(strict_types = 1);

namespace App\Domain\Model\Race;

use App\Domain\Model\Horse\Stats\Distance;
use App\Domain\Model\Race\RaceId;
use App\Domain\Model\Horse\Stats\Seconds;

final class Race
{
    const ADVANCE_SECONDS = 10;

    private $id;
    private $horseRuns;
    private $distance;

    private function __construct(RaceId $id, Distance $distance, array $horseRuns)
    {
        $this->id        = $id;
        $this->distance  = $distance;
        $this->horseRuns = $horseRuns;
    }

    public static function init(int $distance): self
    {
        return new self(RaceId::init(), new Distance($distance), []);
    }

    public static function create(string $id, int $distance, $horseRuns): self
    {
        return new self(
            new RaceId($id),
            new Distance($distance),
            $horseRuns
        );
    }

    public function addHorseRun(HorseRun $horseRun): void
    {
        $this->horseRuns[] = $horseRun;
    }

    public function runForSeconds(int $seconds): void
    {
        foreach ($this->horseRuns as $horseRun) {
            if (!$horseRun->isStillGoing($this->distance)) {
                continue;
            }

            $horseRun->runForSeconds($seconds);
        }
    }

    public function isOver(): bool
    {
        foreach ($this->horseRuns as $horseRun) {
            if ($this->isStillGoing($horseRun)) {
                return false;
            }
        }

        return true;
    }

    public function isStillGoing(HorseRun $horseRun): bool
    {
        return $horseRun->stats()->distanceCovered()->isLessThan($this->distance);
    }

    public function time(): Seconds
    {
        return isset($this->horseRuns[0]) ? $this->horseRuns[0]->stats()->time() : new Seconds(0);
    }

    public function id(): RaceId
    {
        return $this->id;
    }

    public function horseRuns(): array
    {
        return $this->horseRuns;
    }

    public function distance(): Distance
    {
        return $this->distance;
    }

    public function name(): string
    {
        return substr((string) $this->id, 0, 8);
    }
}
