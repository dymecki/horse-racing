<?php

declare(strict_types = 1);

namespace App\Domain\Model\Race;

final class Racing
{
    const MAX_RACES_AMOUNT = 3;

    private $races;

    public function addRace(Race $race): void
    {
        if (count($this->races) === 3) {
            throw new \InvalidArgumentException('There can be only three races');
        }

        $this->races[] = $race;
    }

}
