<?php

declare(strict_types = 1);

include_once('../bootstrap.php');

use App\Application\Services\RaceService;

(new RaceService())->startNewRace();

header('Location: /');
exit;
