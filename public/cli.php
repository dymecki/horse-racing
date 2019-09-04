<?php

declare(strict_types = 1);

require_once '../vendor/autoload.php';
include_once '../bootstrap.php';

use App\Views\RunningHorsesConsole;
use App\Domain\Model\Race\HorseRunInternalState;
use App\Domain\Model\Horse\Horse;
use App\Domain\Model\Horse\HorseId;
use App\Domain\Model\Horse\Stats\HorseStats;
use App\Domain\Model\Race\Stats\HorseRunStats;
use App\Domain\Model\Race\HorseRun;
use jc21\CliTable;
use jc21\CliTableManipulator;

$coveredDistance   = 0;
$maxDistance       = 1500;
$seconds           = 10;
$fullSpeed         = 7;    // 7 m/s
$slowSpeed         = 6.2;  // 6.2 m/s
$fullSpeedDistance = 200;  // 200 m
$slowSpeedDistance = $maxDistance - $fullSpeedDistance; // 1300 m
$fullSpeedSeconds  = $fullSpeedDistance / $fullSpeed; // 28,57 s

$horseRun                   = new \stdClass();
$horseRun->distance_covered = 0;
$horseRun->time             = 0;
$data                       = [];

// Ile razy dodajemy 10 sekund
for ($i = 0; $i < 100; $i++) {

    if ($horseRun->distance_covered >= $maxDistance) {
        continue;
    }

    $forwardTime = $horseRun->time + $seconds;

    if ($forwardTime > $fullSpeedSeconds) {
//        $slowSpeedTime = $forwardTime - $fullSpeedSeconds;
//
//        $slowPartDistance = $slowSpeedTime * $slowSpeed;
//        $coveredDistance  = $fullSpeedDistance + $slowPartDistance;

        $coveredDistance = $fullSpeedDistance + ($forwardTime - $fullSpeedSeconds) * $slowSpeed;
    }
    else {
        $coveredDistance = $forwardTime * $fullSpeed;
    }

    $horseRun->distance_covered = $coveredDistance;
    $horseRun->time             += $seconds;

    if ($coveredDistance > $maxDistance) {
        $diff            = $coveredDistance - $maxDistance;
        $ratio           = $diff / $coveredDistance;
        $coveredDistance = $maxDistance;
        $horseRun->time  = $horseRun->time - $horseRun->time * $ratio;
    }

    $data[] = [
        'time'             => $horseRun->time,
        'distance_covered' => $coveredDistance,
    ];
}

$table = new CliTable;
$table->setTableColor('blue');
$table->setHeaderColor('cyan');

$table->addField('Second', 'time', false, 'white');
$table->addField('Distance covered', 'distance_covered', false, 'white');
//$table->addField('Speed', 'speed', false, 'white');
//$table->addField('m / s', 'metersPerSecond', false, 'white');
//$table->addField('s / m', 'secondsPerMeter', false, 'white');
$table->injectData($data);
$table->display();






exit;

$data      = [];
$endurance = 2.0;
$horse     = new Horse(HorseId::init(), HorseStats::create(2.0, 2.0, $endurance));
$horseRun  = new HorseRun($horse, HorseRunStats::start());
//$horseRun->runForSeconds(5);
//exit;

for ($i = 0; $i < 160; $i++) {
//    $horse = new Horse(
//        HorseId::init(),
//        HorseStats::create(2.0, 2.0, $endurance)
//    );
//
//    $horseRun = new HorseRun($horse, HorseRunStats::start());
    $horseRun->runForSeconds(10);

    $data[] = (new HorseRunInternalState($horseRun))->data();
}

(new RunningHorsesConsole([], $data))->render();
