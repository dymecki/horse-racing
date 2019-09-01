<?php

declare(strict_types = 1);

namespace App\Persistence\Dao;

use App\Domain\Model\Race\RunningHorse;
use App\Domain\Model\Horse\HorseId;
use App\Domain\Model\Horse\Horse;
use App\Domain\Model\Race\Race;

final class HorseDao extends BaseDao
{

    public function addHorse(RunningHorse $runningHorse)
    {
        $this->db()
            ->prepare(
                'INSERT INTO horses (horse_id, speed, strength, endurance)
                 VALUES (:horse_id, :speed, :strength, :endurance)'
            )
            ->execute([
                'horse_id'  => $runningHorse->horse()->id()->value(),
                'speed'     => $runningHorse->horse()->stats()->speed()->distance()->value(),
                'strength'  => $runningHorse->horse()->stats()->strength()->value(),
                'endurance' => $runningHorse->horse()->stats()->endurance()->value()
        ]);
    }

    public function getRunningHorse(HorseId $id): RunningHorse
    {
        $stmt = $this->db()->prepare(
            'SELECT r.*, h.*
               FROM horses h
               JOIN races_horses rh ON rh.horse_id = h.horse_id
               JOIN races r         ON rh.race_id = r.race_id
              WHERE h.horse_id = ?
              LIMIT 1'
        );
        $stmt->execute([$id]);

        return RunningHorse::create($stmt->fetch());
    }

    public function getHorse(HorseId $id): Horse
    {
        $stmt = $this->db()->prepare('SELECT * FROM horses WHERE horse_id = ? LIMIT 1');
        $stmt->execute([$id]);

        return Horse::create($stmt->fetch());
    }

    // TODO: implement proper sql query
    public function getBestEverHorse()
    {
        return $this->db()->query('SELECT * FROM horses LIMIT 1')->fetch();
    }

    public function getAll()
    {
        return $this
                ->db()
                ->query(
                    'SELECT r.*, h.*, rh.*
                       FROM horses h
                       JOIN races_horses rh ON rh.horse_id = h.horse_id
                       JOIN races r         ON rh.race_id = r.race_id'
                )
                ->fetchAll();
    }

    public function updateHorseProgress(Race $race, RunningHorse $horse)
    {
        $this->db()
            ->prepare(
                'UPDATE races_horses
                    SET distance_covered = :distance_covered,
                        time = :time
                  WHERE race_id = :race_id
                    AND horse_id = :horse_id'
            )
            ->execute([
                'distance_covered' => $horse->stats()->distanceCovered()->value(),
                'time'             => $horse->stats()->time()->value(),
                'race_id'          => $race->id(),
                'horse_id'         => $horse->horse()->id()
        ]);
    }
}
