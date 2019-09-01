<!doctype html>
<html>
    <head>
        <meta charset="utf-8">
        <title>Horse Racing Simulator</title>
        <meta name="viewport" content="width=device-width, initial-scale=1.0">
        <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/twitter-bootstrap/4.3.1/css/bootstrap.min.css" integrity="sha256-YLGeXaapI0/5IgZopewRJcFXomhRMlYYjugPLSyNjTY=" crossorigin="anonymous" />

        <style>
            .container nav.navbar {
                margin-bottom: 20px;
            }

            .row.bottom {
                border-top: 1px solid #efefef;
                padding: 30px;
                text-align: center;
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
                <a href="{{ route('progress') }}" class="btn btn-primary">progress</a>
            </nav>

            <div class="row">
                <div class="col-md-12 content">
                    @yield('content')
                </div>
            </div>

            <div class="row bottom">
                <div class="col-md-12">
                    <p>Copyright {{ date('Y') }}</p>
                </div>
            </div>
        </div>
    </body>
</html>
