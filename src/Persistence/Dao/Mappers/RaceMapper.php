<?php

declare(strict_types = 1);

namespace App\Persistence\Dao\Mappers;

use App\Domain\Model\Race\Race;
use App\Domain\Model\Race\RunningHorse;

final class RaceMapper
{
    private $data;

    public function __construct(array $data)
    {
        $this->data = $data;
    }

    public function get(): array
    {
//        var_dump($this->data);
        $races = [];

        foreach ($this->data as $raceId => $items) {
            $distance = isset($items[0]) ? $items[0]->distance : 0;
            $race     = Race::create($raceId, $distance, []);

            foreach ($items as $item) {
                $race->addRunningHorse(RunningHorse::create($item));
            }

            $races[] = $race;
        }

//        var_dump($races);exit;
        return $races;
    }
}
