<?php

declare(strict_types = 1);

namespace App\Persistence\Dao;

use App\Domain\Model\Race\RunningHorse;
use App\Domain\Model\Horse\HorseId;
use App\Domain\Model\Horse\Horse;

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
               JOIN races_horses rh
                 ON rh.horse_id = h.horse_id
               JOIN races r
                 ON rh.race_id = r.race_id
              WHERE h.horse_id = ?'
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

    public function addNewProgress($raceHorseId)
    {
        $this->db()
            ->prepare('INSERT INTO horses_progress (race_horse_id) VALUES (?)')
            ->execute([$raceHorseId]);
    }

    public function getBestEverHorse()
    {
        return $this->db()->query('SELECT * FROM horses LIMIT 1')->fetch();
    }

    public function getAll()
    {
        return $this
                ->db()
                ->query(
                    'SELECT r.*, h.*, hp.*
                       FROM horses h
                       JOIN races_horses rh     ON rh.horse_id = h.horse_id
                       JOIN races r             ON rh.race_id = r.race_id
                       JOIN horses_progress hp  ON hp.race_horse_id = rh.race_horse_id'
                )
                ->fetchAll();
    }
}
