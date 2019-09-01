<?php

use App\Application\Services\RaceService;
use App\Application\Services\HorseService;
use App\Persistence\Dao\Mappers\RaceMapper;

$raceService = new RaceService();
$races       = $raceService->activeRaces();

$raceMapper = new RaceMapper($races);
$races      = $raceMapper->get();
//exit;

$horseService = new HorseService();
$horses       = $horseService->getAll();

//var_dump($races);
//exit;

?>
<!doctype html>
<html>
    <head>
        <meta charset="utf-8">
        <title>Horse Racing Simulator (custom)</title>
        <meta name="viewport" content="width=device-width, initial-scale=1.0">
        <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/twitter-bootstrap/4.3.1/css/bootstrap.min.css" integrity="sha256-YLGeXaapI0/5IgZopewRJcFXomhRMlYYjugPLSyNjTY=" crossorigin="anonymous" />

        <style>
            .container nav.navbar {
                margin-bottom: 20px;
            }
        </style>
    </head>
    <body>
        <div class="container _container-fluid">
            <nav class="navbar navbar-expand-lg navbar-light bg-light">
                <a class="navbar-brand" href="#">HorseRacing</a>

                <button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#navbarNavAltMarkup" aria-controls="navbarNavAltMarkup" aria-expanded="false" aria-label="Toggle navigation">
                    <span class="navbar-toggler-icon"></span>
                </button>

                <div class="collapse navbar-collapse" id="navbarNavAltMarkup">
                    <div class="navbar-nav">
                        <a class="nav-item nav-link active" href="#">Home <span class="sr-only">(current)</span></a>
                        <a class="nav-item nav-link" href="#">Features</a>
                        <a class="nav-item nav-link" href="#">Pricing</a>
                        <a class="nav-item nav-link disabled" href="#" tabindex="-1" aria-disabled="true">Disabled</a>
                    </div>
                </div>

                <a href="/create-race.php" class="btn btn-success">create race</a>
                <a href="/progress.php" class="btn btn-primary">progress</a>
            </nav>

            <div class="row">
                <!--<div class="col-md-4 nav"></div>-->
                <div class="col-md-12 content">


                    <div class="">
                        <h3>All races</h3>

                        <table class="table table-striped table-sm">
                            <thead>
                                <tr>
                                    <th scope="col">Race id</th>
                                    <th scope="col">Distance</th>
                                    <th scope="col">Started at</th>
                                    <th scope="col">Best time</th>
                                </tr>
                            </thead>
                            <tbody>

                                <?php foreach ($races as $race): ?>

                                    <tr>
                                        <td><a href="/race.php?id=<?= $race->id(); ?>" title="Show race's details"><?= substr($race->id(), 0, 8); ?></a></td>
                                        <td><?= $race->distance(); ?></td>
                                        <td></td>
                                        <td></td>
                                    </tr>

                                <?php endforeach; ?>

                            </tbody>
                        </table>
                    </div>

                    <div class="">
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
                                        <td><?= substr($horse->horse_id, 0, 8); ?></td>
                                        <td><?= $horse->speed; ?></td>
                                        <td><?= $horse->strength; ?></td>
                                        <td><?= $horse->endurance; ?></td>
                                        <td><?= $horse->created_at; ?></td>
                                    </tr>

                                <?php endforeach; ?>

                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
        </div>
    </body>
</html>
