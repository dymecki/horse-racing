<?php

declare(strict_types = 1);

include_once('../bootstrap.php');

$raceService->updateRaces();

header('Location: index.php');
exit;
