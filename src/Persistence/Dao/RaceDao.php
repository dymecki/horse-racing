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

    public function updateRaceProgress(Race $race)
    {
        foreach ($race->runningHorses() as $horse) {
            $this->horse->updateHorseProgress($race, $horse);
        }
    }

    public function addRace(Race $race)
    {
        $this->db()->beginTransaction();

        $this->db()
            ->prepare('INSERT INTO races (race_id, distance) VALUES(?, ?)')
            ->execute([$race->id(), $race->distance()->value()]);

        $horses = $race->runningHorses();

        foreach ($horses as $horse) {
            $this->horse->addHorse($horse);

            $this->db()
                ->prepare('INSERT INTO races_horses (race_id, horse_id) VALUES(?, ?)')
                ->execute([$race->id(), $horse->horse()->id()]);
        }

        $this->db()->commit();
    }

    // TODO: Add propersql query
    public function countActiveRaces(): int
    {
        return $this->db()->query('SELECT count(*) FROM races')->fetch()->count;
    }

    // TODO: Limit to last 5 races
    public function getLastRacesBestPositions(int $racesAmount = 5)
    {
        $stmt = $this->db()
            ->prepare('
            SELECT *
            FROM (
                 SELECT rh.*,
                        ROW_NUMBER() OVER (
                            PARTITION BY race_id
                            ORDER by distance_covered desc
                        ) rownumber
                  FROM  races_horses rh
            ) tmp
            JOIN races r ON tmp.race_id = r.race_id
            JOIN horses h ON tmp.horse_id = h.horse_id
            WHERE rownumber <= 3
                ');
        $stmt->execute([$racesAmount]);
        
        return $stmt->fetchAll(\PDO::FETCH_GROUP);
    }
}
