<?php

declare(strict_types = 1);

include_once '../bootstrap.php';

$raceService->startNewRace();

header('Location: index.php');
exit;
