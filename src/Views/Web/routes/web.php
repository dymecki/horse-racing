<?php

declare(strict_types = 1);

use App\Application\Services\RaceService;

Route::get('/', function() {
    return view('main')->with('races', (new RaceService())->activeRaces());
})->name('index');

Route::get('races/{id}', function($id) {
    return view('races.show')->with('race', (new RaceService())->getById($id));
})->name('races.show');

Route::get('progress', function() {
    (new RaceService())->updateRaces();

    return redirect()->route('index');
})->name('progress');

Route::get('create-race', function() {
    (new RaceService())->startNewRace();

    return redirect()->route('index');
})->name('create');

Route::get('last-races', function() {
    return view('races.last')->with('races', (new RaceService())->getLastRacesBestPositions());
})->name('last-races');
