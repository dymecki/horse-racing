<?php

declare(strict_types = 1);

namespace App\Persistence\Dao;

use App\Domain\Model\Race\Race;
use App\Persistence\Dao\HorseDao;

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
                    rh.distance_covered,
                    rh."time"
               FROM races r

               JOIN races_horses rh ON rh.race_id = r.race_id
               JOIN horses h        ON rh.horse_id = h.horse_id

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
                        rh.distance_covered,
                        rh."time"
                   FROM races r

                   JOIN races_horses rh ON rh.race_id = r.race_id
                   JOIN horses h        ON rh.horse_id = h.horse_id

                  WHERE rh.distance_covered < r.distance'
            )->fetchAll(\PDO::FETCH_GROUP);
    }

    public function getRaceHorses(string $raceId)
    {
        $stmt = $this->db()->prepare(
            'SELECT rh.horse_id,
                    p.distance_covered,
                    "time"
               FROM races_horses rh

               JOIN progress p ON p.race_id = r.race_id

              WHERE rh.race_id = ?'
        );

        $stmt->execute([$raceId]);

        return $stmt->fetchAll();
    }

    public function updateRaceProgress(Race $race)
    {
        foreach ($race->horses() as $horse) {
            $this->horse->updateHorseProgress($race, $horse);
        }
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

            $this->db()
                ->prepare('INSERT INTO races_horses (race_id, horse_id) VALUES(?, ?)')
                ->execute([$race->id(), $horse->horse()->id()]);

            $this->horse->addNewProgress($race, $horse->horse());
        }

        $this->db()->commit();
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
