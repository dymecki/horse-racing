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
        $sql = 'SELECT r.race_id,
                       r.distance,
                       h.horse_id,
                       h.speed,
                       h.strength,
                       h.endurance,
                       rh.distance_covered,
                       rh."time"
                  FROM races r
                  JOIN races_horses rh USING(race_id)
                  JOIN horses h        USING(horse_id)
                 WHERE r.race_id = ?';

        $stmt = $this->db()->prepare($sql);
        $stmt->execute([$raceId]);

        return $stmt->fetch();
    }

    public function getActiveRaces(): array
    {
        $sql = 'SELECT r.race_id,
                       r.distance,
                       h.horse_id,
                       h.speed,
                       h.strength,
                       h.endurance,
                       rh.distance_covered,
                       rh."time",
                       ROW_NUMBER() OVER(PARTITION BY r.race_id ORDER BY rh.distance_covered DESC) horse_position
                  FROM races r

                  JOIN (SELECT r.race_id AS rid
                          FROM races_horses rh
                          JOIN races r USING(race_id)
                         WHERE rh.distance_covered < r.distance
                         GROUP BY r.race_id) selected_races
                    ON selected_races.rid = r.race_id

                  JOIN races_horses rh USING(race_id)
                  JOIN horses h        USING(horse_id)';

        return $this->db()->query($sql)->fetchAll(\PDO::FETCH_GROUP);
    }

    public function updateRaceProgress(Race $race)
    {
        foreach ($race->horseRuns() as $horse) {
            $this->horse->updateHorseProgress($race, $horse);
        }
    }

    public function addRace(Race $race)
    {
        $this->db()->beginTransaction();

        $this->db()
            ->prepare('INSERT INTO races (race_id, distance) VALUES(?, ?)')
            ->execute([$race->id(), $race->distance()->value()]);

        $horses = $race->horseRuns();

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
        $sql = 'SELECT count(*)
                  FROM races r
                  JOIN races_horses rh USING(race_id)
               -- JOIN horses h        USING(horse_id)
                 WHERE rh.distance_covered < r.distance';

        return (int) $this->db()->query($sql)->fetch()->count;
    }

    public function getLastRacesBestPositions(): array
    {
        $sql = 'SELECT tmp.*,
                       distance,
                       speed,
                       strength,
                       endurance

                  FROM (SELECT race_id,
                               horse_id,
                               distance_covered,
                               "time",
                               RANK() OVER (PARTITION BY race_id ORDER BY rh.distance_covered desc) horse_position,
                               DENSE_RANK() OVER (ORDER BY race_id) partition_number
                          FROM races_horses rh) tmp

                  JOIN races r  USING(race_id)
                  JOIN horses h USING(horse_id)
                 WHERE horse_position <= 3
                   AND partition_number <= 5
                 ORDER BY r.race_id, tmp.horse_position ASC';

        $stmt = $this->db()->prepare($sql);
        $stmt->execute();

        return $stmt->fetchAll(\PDO::FETCH_GROUP);
    }
}
