<?php

declare(strict_types = 1);

namespace App\Persistence\Dao;

use App\Domain\Model\Race\Race;
use App\Persistence\Dao\HorseDao;
use App\Domain\Model\Race\HorseRun;

final class RaceDao extends BaseDao
{
    private $horse;

    public function __construct()
    {
        parent::__construct();

        $this->horse = new HorseDao();
    }

    /**
     *
     * @return \stdClass[]
     */
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
                       ROW_NUMBER() OVER(PARTITION BY r.race_id
                                         ORDER BY rh.distance_covered DESC) horse_position
                  FROM races r
                  JOIN active_races_view USING(race_id)
                  JOIN races_horses rh   USING(race_id)
                  JOIN horses h          USING(horse_id)';

        return $this->db->query($sql)->fetchAll(\PDO::FETCH_GROUP);
    }

    public function updateRaceProgress(Race $race): void
    {
        $this->db->beginTransaction();

        foreach ($race->horseRuns() as $horse) {
            $this->horse->updateHorseProgress($race, $horse);
        }

        $this->db->commit();
    }

    public function addRace(Race $race): void
    {
        $this->db->beginTransaction();

        $this->db
            ->prepare('INSERT INTO races (race_id, distance) VALUES(?, ?)')
            ->execute([$race->id(), $race->distance()->value()]);

        $horseRuns = $race->horseRuns();

        /* @var $horseRuns HorseRun[] */
        foreach ($horseRuns as $horseRun) {
            $this->horse->addHorse($horseRun->horse());

            $this->db
                ->prepare('INSERT INTO races_horses (race_id, horse_id) VALUES(?, ?)')
                ->execute([$race->id(), $horseRun->horse()->id()]);
        }

        $this->db->commit();
    }

    public function countActiveRaces(): int
    {
        $sql = 'SELECT count(*) FROM active_races_view';

        return (int) $this->db->query($sql)->fetch()->count;
    }

    /**
     *
     * @return \stdClass[]
     */
    public function getLastRacesBestPositions(): array
    {
        $sql = 'SELECT *
                  FROM (SELECT *,
                               DENSE_RANK() OVER (ORDER BY created_at DESC) partition_number,
                               ROW_NUMBER() OVER (PARTITION BY race_id ORDER BY "time" ASC) horse_position
                          FROM finished_races_view) tmp
                 WHERE horse_position <= 3 AND partition_number <= 5
                 ORDER BY partition_number ASC, horse_position ASC';

        $stmt = $this->db->prepare($sql);
        $stmt->execute();

        return $stmt->fetchAll(\PDO::FETCH_GROUP);
    }
}
