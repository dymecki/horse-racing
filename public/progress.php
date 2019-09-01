<?php

declare(strict_types = 1);

require_once '../vendor/autoload.php';

use App\Application\Services\RaceService;
use App\Persistence\Dao\Mappers\RaceMapper;

$raceService = new RaceService();
$raceMapper  = new RaceMapper($raceService->activeRaces());
$races       = $raceMapper->get();

foreach ($races as $race) {
    $race->runForSeconds(10);
}

header('Location: /');
exit();
