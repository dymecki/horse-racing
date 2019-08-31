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
$runningHorse = HorseFactory::make();

//$raceDao->addRace($race);
//$horseDao->addHorse($horse);

$runningHorse->runForSeconds(10);
$console = new RunningHorsesConsole([$runningHorse]);
$console->render();
exit;

for ($i = 0; $i < 5; $i++) {
    $console = new RunningHorsesConsole([$runningHorse]);
    $console->render();
    $runningHorse->move();
}

//$console = new RunningHorsesConsole([$horse]);
//$console->render();
exit;


$step = 1;

while ($step < 3) {
    $race->moveHorses();

    echo 'Step: ' . $step . "\n";
    $console = new RunningHorsesConsole($race->horses());
    $console->render();
    $step++;
}
