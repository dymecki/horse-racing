<?php

declare(strict_types = 1);

require_once '../vendor/autoload.php';

use App\Domain\Model\Race\RaceFactory;
use App\Domain\Model\Horse\HorseFactory;
use App\Views\RunningHorsesConsole;
use App\Persistence\Dao\RaceDao;
use App\Persistence\Dao\HorseDao;

$raceDao  = new RaceDao();
$horseDao = new HorseDao();

$race  = RaceFactory::make();
$horse = HorseFactory::make();

//$raceDao->addRace($race);
//$horseDao->addHorse($horse);



$step = 1;

while (!$race->isOver()) {
    $race->moveHorses();

    echo 'Step: ' . $step . "\n";
    echo new RunningHorsesConsole($race->horses());
    $step++;
}
