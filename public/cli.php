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

$data      = [];
$endurance = 0.35;


//$horse = new Horse(
//    HorseId::init(),
//    HorseStats::create(2.0, 2.0, $endurance)
//);
//
//$horseRun = new HorseRun($horse, HorseRunStats::start());
//$horseRun->runForSeconds(5);
//exit;


for ($i = 1; $i < 11; $i++) {
    $horse = new Horse(
        HorseId::init(),
        HorseStats::create(2.0, 2.0, $endurance)
    );

    $horseRun = new HorseRun($horse, HorseRunStats::start());
    $horseRun->runForSeconds($i);

    $data[] = (new HorseRunInternalState($horseRun))->data();
}

(new RunningHorsesConsole($data))->render();
