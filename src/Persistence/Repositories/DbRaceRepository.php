<?php

declare(strict_types = 1);

namespace App\Persistence\Repositories;

use App\Domain\Model\Race\Stats\HorseRunStats;
use \PDO;
use App\Domain\Model\Race\HorseRun;
use App\Domain\Model\Horse\Horse;
use App\Domain\Model\Race\Race;
use App\Domain\Model\Race\RaceRepository;
use App\Domain\Model\Race\RaceCollection;

final class DbRaceRepository extends DbRepository implements RaceRepository
{
    private $horse;

    public function __construct()
    {
        parent::__construct();
        $this->horse = new DbHorseRepository();
    }

    public function activeRaces(): RaceCollection
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

        $data = $this->db->query($sql)->fetchAll(PDO::FETCH_CLASS|PDO::FETCH_GROUP);

        return $this->get($data);
    }

    public function updateRaceProgress(Race $race): void
    {
        $this->db->beginTransaction();

        foreach ($race->horseRuns() as $horse) {
            $this->horse->updateHorseProgress($race, $horse);
        }

        $this->db->commit();
    }

    public function add(Race $race): void
    {
        $this->db->beginTransaction();

        $this->db
            ->prepare('INSERT INTO races (race_id, distance) VALUES(?, ?)')
            ->execute([$race->id(), $race->distance()->value()]);

        $horseRuns = $race->horseRuns();

        /* @var $horseRuns HorseRun[] */
        foreach ($horseRuns as $horseRun) {
            $this->horse->add($horseRun->horse());

            $this->db
                ->prepare('INSERT INTO races_horses (race_id, horse_id) VALUES(?, ?)')
                ->execute([$race->id(), $horseRun->horse()->id()]);
        }

        $this->db->commit();
    }

    public function activeRacesAmount(): int
    {
        $sql = 'SELECT count(*) FROM active_races_view';

        return (int) $this->db->query($sql)->fetch()->count;
    }

    public function lastRacesBestPositions(): RaceCollection
    {
        $sql = 'SELECT *
                  FROM (SELECT *,
                               DENSE_RANK() OVER (ORDER BY created_at DESC) race_number,
                               ROW_NUMBER() OVER (PARTITION BY race_id ORDER BY "time") horse_position
                          FROM finished_races_view) tmp
                 WHERE horse_position <= 3 AND race_number <= 5
                 ORDER BY race_number, horse_position';

        $data = $this->db->query($sql)->fetchAll(PDO::FETCH_CLASS|PDO::FETCH_GROUP);

        return $this->get($data);
    }

    private function get(array $data): RaceCollection
    {
        $races = RaceCollection::obj();

        foreach ($data as $raceId => $items) {
            $distance = isset($items[0]) ? $items[0]->distance : 0;
            $race     = Race::fromData($raceId, (int) $distance);

            /** @var $items \stdClass[] */
            foreach ($items as $item) {
                $race->addHorseRun($this->horseRunFromData($item));
            }

            $races->add($race);
        }

        return $races;
    }

    private function horseRunFromData(\stdClass $data): HorseRun
    {
        $horse = Horse::obj(
            $data->horse_id,
            (float) $data->speed,
            (float) $data->strength,
            (float) $data->endurance
        );

        $horseStats = HorseRunStats::obj(
            (float) $data->distance_covered,
            (float) $data->time,
            $data->horse_position ?? 0
        );

        return new HorseRun($horse, $horseStats);
    }
}
