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
        $sql = 'INSERT INTO horses (horse_id, speed, strength, endurance)
                VALUES (:horse_id, :speed, :strength, :endurance)';

        $data = [
            'horse_id'  => $runningHorse->horse()->id()->value(),
            'speed'     => $runningHorse->horse()->stats()->speed()->distance()->value(),
            'strength'  => $runningHorse->horse()->stats()->strength()->value(),
            'endurance' => $runningHorse->horse()->stats()->endurance()->value()
        ];

        $this->db()->prepare($sql)->execute($data);
    }

    // TODO: Tabela "races" chyba nie jest potrzebna
    public function getRunningHorse(HorseId $id): RunningHorse
    {
        $sql = 'SELECT r.*, h.*
                  FROM horses h
                  JOIN races_horses rh USING(horse_id)
                  JOIN races r         USING(race_id)
                 WHERE h.horse_id = ?
                 LIMIT 1';

        $stmt = $this->db()->prepare($sql);
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

    public function getAll(): array
    {
        $sql = 'SELECT r.*, h.*, rh.*
                       FROM horses h
                       JOIN races_horses rh USING(horse_id)
                       JOIN races r         USING(race_id)';

        return $this->db()->query($sql)->fetchAll();
    }

    public function updateHorseProgress(Race $race, RunningHorse $horse): void
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

        $this->db()->prepare($sql)->execute($data);
    }
}
