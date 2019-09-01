<?php

declare(strict_types = 1);

namespace App\Persistence\Dao;

use App\Domain\Model\Race\Race;
use App\Persistence\Dao\HorseDao;
use Ramsey\Uuid\Uuid;

final class RaceDao extends BaseDao
{
    private $horse;

    public function __construct()
    {
        parent::__construct();

        $this->horse = new HorseDao();
    }

    public function getById(string $raceId)
    {
        $stmt = $this->db()->prepare(
            'SELECT r.race_id,
                    r.distance,
                    h.horse_id,
                    h.speed,
                    h.strength,
                    h.endurance,
                    hp.race_horse_id,
                    hp.distance_covered,
                    hp."time"
               FROM races r

               JOIN races_horses rh     ON rh.race_id = r.race_id
               JOIN horses h            ON rh.horse_id = h.horse_id
               JOIN horses_progress hp  ON hp.race_horse_id = rh.race_horse_id

              WHERE r.race_id = ?'
        );
        $stmt->execute([$raceId]);

        return $stmt->fetch();
    }

    public function getActiveRaces()
    {
        return $this->db()->query(
                'SELECT r.race_id,
                        r.distance,
                        h.horse_id,
                        h.speed,
                        h.strength,
                        h.endurance,
                        hp.race_horse_id,
                        hp.distance_covered,
                        hp."time"
                   FROM races r

                   JOIN races_horses rh     ON rh.race_id = r.race_id
                   JOIN horses h            ON rh.horse_id = h.horse_id
                   JOIN horses_progress hp  ON hp.race_horse_id = rh.race_horse_id

                  WHERE hp.distance_covered < r.distance'
            )->fetchAll(\PDO::FETCH_GROUP);
    }

    public function getRaceHorses(string $raceId)
    {
        $stmt = $this->db()->prepare(
            'SELECT rh.horse_id, hp.distance_covered, time
               FROM races_horses rh

               JOIN horses_progress hp
                 ON hp.race_horse_id = rh.race_horse_id

              WHERE race_id = ?'
        );

        $stmt->execute([$raceId]);

        return $stmt->fetchAll();
    }

    public function updateRaceProgress($runningHorse)
    {
        $this->db()
            ->prepare(
                'UPDATE horses_progress
                    SET distance_covered = :distance_covered,
                        time = :time
                  WHERE race_horse_id = :race_horse_id'
            )
            ->execute([
                'distance_covered' => $race,
                'time'             => $race,
                'race_horse_id'    => $race
        ]);
    }

    public function addRace(Race $race)
    {
        $this->db()->beginTransaction();

        $this->db()
            ->prepare('INSERT INTO races (race_id, distance) VALUES(?, ?)')
            ->execute([$race->id(), $race->distance()->value()]);

        $horses = $race->horses();

        foreach ($horses as $horse) {
            $this->horse->addHorse($horse);
        }

        $this->assignHorses($race, $horses);

        $this->db()->commit();
    }

    public function assignHorses(Race $race, $horses)
    {
        foreach ($horses as $horse) {
            $raceHorseId = Uuid::uuid4()->toString();

            $this->db()
                ->prepare('INSERT INTO races_horses (race_horse_id, race_id, horse_id) VALUES(:race_horse_id, :race_id, :horse_id)')
                ->execute([
                    'race_horse_id' => $raceHorseId,
                    'race_id'       => $race->id()->value(),
                    'horse_id'      => $horse->horse()->id()->value()
            ]);

            $this->horse->addNewProgress($raceHorseId);
        }
    }

    public function getAll()
    {
        return $this->db()->query('SELECT * FROM races ORDER BY created_at DESC')->fetchAll();
    }

    public function countActiveRaces(): int
    {
        return $this->db()->query('SELECT count(*) FROM races')->fetch()->count;
    }
}
