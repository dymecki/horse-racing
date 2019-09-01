<?php
declare(strict_types = 1);

require_once '../vendor/autoload.php';

use App\Application\Services\RaceService;
use App\Application\Services\HorseService;

$raceService = new RaceService();
$race        = $raceService->getById($_GET['id']);
$horses      = $raceService->getRaceHorses($_GET['id']);

$horseService = new HorseService();
//$horses = $horseService->getAll();
//$horse = $horseService->getById('c7fd4b1d-94c8-4107-938b-48a916a8b7e1');
//$horse = $horseService->getRuningHorse($_GET['id']);
//
//var_dump($horse);
//exit;

?>
<!doctype html>
<html>
    <head>
        <meta charset="utf-8">
        <title>Horse Racing Simulator (custom)</title>
        <meta name="viewport" content="width=device-width, initial-scale=1.0">
        <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/twitter-bootstrap/4.3.1/css/bootstrap.min.css" integrity="sha256-YLGeXaapI0/5IgZopewRJcFXomhRMlYYjugPLSyNjTY=" crossorigin="anonymous" />
    </head>
    <body>
        <div class="container _container-fluid">
            <div class="row">
                <div class="col-md-12 content">
                    <a href="/create-race.php" class="btn btn-secondary">create race</a>
                    <a href="/progress.php" class="btn btn-secondary">progress</a>

                    <div class="">
                        <h3>Race <?= $race->race_id; ?></h3>

                        <table class="table table-striped table-sm">
                            <thead>
                                <tr>
                                    <th scope="col">Horse id</th>
                                    <th scope="col">Distance covered</th>
                                    <th scope="col">Time</th>
                                </tr>
                            </thead>
                            <tbody>

                                <?php foreach ($horses as $horse): ?>

                                    <tr>
                                        <td><?= substr($horse->horse_id, 0, 8); ?></td>
                                        <td>
                                            <div class="progress">
                                                <div
                                                    class="progress-bar progress-bar-striped bg-success"
                                                    role="progressbar"
                                                    style="width: <?= $horse->distance_covered; ?>%"
                                                    aria-valuenow="<?= $horse->distance_covered; ?>"
                                                    aria-valuemin="0"
                                                    aria-valuemax="100"></div>
                                            </div>
                                        </td>
                                        <td><?= $horse->time; ?> s</td>
                                    </tr>

                                <?php endforeach; ?>

                            </tbody>
                        </table>
                    </div>

                    <!--                    <div class="">
                                            <h3>All horses</h3>

                                            <table class="table table-striped table-sm">
                                                <thead>
                                                    <tr>
                                                        <th scope="col">Horse id</th>
                                                        <th scope="col">Speed</th>
                                                        <th scope="col">Strength</th>
                                                        <th scope="col">Endurance</th>
                                                        <th scope="col">Created at</th>
                                                    </tr>
                                                </thead>
                                                <tbody>

                    <?php foreach ($horses as $horse): ?>

                                                                            <tr>
                                                                                <td><?= $horse->id; ?></td>
                                                                                <td><?= $horse->speed; ?></td>
                                                                                <td><?= $horse->strength; ?></td>
                                                                                <td><?= $horse->endurance; ?></td>
                                                                                <td><?= $horse->created_at; ?></td>
                                                                            </tr>

                    <?php endforeach; ?>

                                                </tbody>
                                            </table>
                                        </div>-->
                </div>
            </div>
        </div>
    </body>
</html>
