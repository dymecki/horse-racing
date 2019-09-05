<?php

declare(strict_types = 1);

include_once('../bootstrap.php');

use App\Application\Services\RaceService;

(new RaceService())->updateRaces();

header('Location: index.php');
exit;
