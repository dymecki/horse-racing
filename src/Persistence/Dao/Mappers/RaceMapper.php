<?php

declare(strict_types = 1);

namespace App\Persistence\Dao\Mappers;

use App\Domain\Model\Race\Race;
use App\Domain\Model\Race\HorseRun;

final class RaceMapper
{
    private $data;

    public function __construct(array $data)
    {
        $this->data = $data;
    }

    public function get(): array
    {
        $races = [];

        foreach ($this->data as $raceId => $items) {
            $distance = isset($items[0]) ? $items[0]->distance : 0;
            $race     = Race::create($raceId, $distance, []);

            /* @var $items \stdClass[] */
            foreach ($items as $item) {
                $race->addHorseRun(HorseRun::create($item));
            }

            $races[] = $race;
        }

        return $races;
    }
}
