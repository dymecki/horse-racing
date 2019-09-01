<?php

declare(strict_types = 1);

use App\Application\Services\RaceService;
//use App\Application\Services\HorseService;
use App\Persistence\Dao\Mappers\RaceMapper;

Route::get('/', function() {
    $raceService = new RaceService();
    $races       = $raceService->activeRaces();

    $raceMapper = new RaceMapper($races);
    $races      = $raceMapper->get();

//    $horseService = new HorseService();
//    $horses       = $horseService->getAll();
//    var_dump($races);exit;

    return view('main')->with('races', $races);
})->name('index');

Route::get('races/{id}', function($id) {
    $raceService = new RaceService();
    $race        = $raceService->getById($id);

    $raceMapper = new RaceMapper([$race]);
    $race       = $raceMapper->get();
//    var_dump($race);exit;

    return view('races.show')->with('race', $race);
})->name('races.show');

Route::get('progress', function() {
    $raceService = new RaceService();
    $raceMapper  = new RaceMapper($raceService->activeRaces());
    $races       = $raceMapper->get();

    foreach ($races as $race) {
        $race->runForSeconds(10);
    }

    return redirect()->route('index');
})->name('progress');

Route::get('create-race', function() {
    $raceService = new RaceService();
    $raceService->startNewRace();

    return redirect()->route('index');
})->name('create');
