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

    public static function create(\stdClass $data): self
    {
        return new self(
            HorseId::create($data->horse_id),
            HorseStats::create(
                (float) $data->speed,
                (float) $data->strength,
                (float) $data->endurance
            )
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

    public function __toString()
    {
        return sprintf('%s', $this->id);
    }
}
