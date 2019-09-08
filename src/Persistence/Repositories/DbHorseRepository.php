<?php

declare(strict_types = 1);

namespace App\Persistence\Repositories;

use App\Domain\Model\Race\Stats\HorseRunStats;
use App\Domain\Model\Race\HorseRun;
use App\Domain\Model\Horse\Horse;
use App\Domain\Model\Race\Race;
use App\Domain\Model\Horse\HorseRepository;

final class DbHorseRepository extends DbRepository implements HorseRepository
{
    public function add(Horse $horse): void
    {
        $sql = 'INSERT INTO horses (horse_id, speed, strength, endurance)
                VALUES (:horse_id, :speed, :strength, :endurance)';

        $data = [
            'horse_id'  => $horse->id()->value(),
            'speed'     => $horse->stats()->speed()->distance()->value(),
            'strength'  => $horse->stats()->strength()->value(),
            'endurance' => $horse->stats()->endurance()->value()
        ];

        $this->db->prepare($sql)->execute($data);
    }

    public function bestHorseRunEver(): ?HorseRun
    {
        $sql  = 'SELECT * FROM finished_races_view ORDER BY "time" LIMIT 1';
        $data = $this->db->query($sql)->fetchObject();

        if (!$data) {
            return null;
        }

        $horse = Horse::obj(
            $data->horse_id,
            (float) $data->speed,
            (float) $data->strength,
            (float) $data->endurance
        );

        $horseRunStats = HorseRunStats::obj(
            (float) $data->distance_covered,
            (float) $data->time
        );

        return new HorseRun($horse, $horseRunStats);
    }

    public function updateHorseProgress(Race $race, HorseRun $horse): void
    {
        $sql = 'UPDATE races_horses
                   SET distance_covered = :distance_covered,
                       time = :time
                 WHERE race_id = :race_id
                   AND horse_id = :horse_id';

        $data = [
            'distance_covered' => $horse->stats()->distanceCovered()->value(),
            'time'             => $horse->stats()->time()->value(),
            'race_id'          => $race->id(),
            'horse_id'         => $horse->horse()->id()
        ];

        $this->db->prepare($sql)->execute($data);
    }
}
