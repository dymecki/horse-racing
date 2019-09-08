<?php

declare(strict_types = 1);

namespace App\Domain\Model\Horse;

use App\Domain\Model\Horse\Stats\HorseStats;

final class Horse
{
    private $id;
    private $stats;

    public function __construct(HorseId $id, HorseStats $stats)
    {
        $this->id    = $id;
        $this->stats = $stats;
    }

    public static function obj(string $id, float $speed, float $strength, float $endurance): self
    {
        return new self(
            HorseId::fromString($id),
            HorseStats::obj($speed, $strength, $endurance)
        );
    }

    public function id(): HorseId
    {
        return $this->id;
    }

    public function stats(): HorseStats
    {
        return $this->stats;
    }

    public function name(): string
    {
        return substr((string) $this->id, 0, 8);
    }
}
