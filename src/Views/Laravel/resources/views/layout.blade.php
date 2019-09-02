<!doctype html>
<html>
    <head>
        <meta charset="utf-8">
        <title>@yield('title', 'Horse Racing Simulator')</title>
        <meta name="viewport" content="width=device-width, initial-scale=1.0">
        <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/twitter-bootstrap/4.3.1/css/bootstrap.min.css" integrity="sha256-YLGeXaapI0/5IgZopewRJcFXomhRMlYYjugPLSyNjTY=" crossorigin="anonymous" />

        <style>
            h1, h2,h3,h4,h5,h6 {
                color: #909090;
            }
            body {
                /*background-color: #454d55;*/
            }

            .container nav.navbar {
                margin-bottom: 20px;
            }

            .row.bottom {
                border-top: 1px solid #efefef;
                color: #909090;
                padding: 30px;
                text-align: center;
            }

            .progress {
                /*background-color: #606060;*/
                background-color: transparent;
                -webkit-box-shadow: none;
                box-shadow: none;
            }

        </style>
    </head>
    <body class="_bg-dark">
        <div class="container _container-fluid">
            <nav class="navbar navbar-expand-lg navbar-dark bg-dark">
                <a href="{{ route('index') }}" class="navbar-brand">Horse Racing Simulator</a>

                <button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#navbarNavAltMarkup" aria-controls="navbarNavAltMarkup" aria-expanded="false" aria-label="Toggle navigation">
                    <span class="navbar-toggler-icon"></span>
                </button>

                <div class="collapse navbar-collapse" id="navbarNavAltMarkup">
                    <div class="navbar-nav">
                        <a  href="{{ route('index') }}" class="nav-item nav-link _active">Home <span class="sr-only">(current)</span></a>
                        <a href="{{ route('last-races') }}" class="nav-item nav-link">Last 5 races</a>
                        <!--<a href="#" class="nav-item nav-link disabled" tabindex="-1" aria-disabled="true">Disabled</a>-->
                    </div>
                </div>

                <div class="btn-group float-right" role="group" aria-label="Basic example">
                    <!--<button type="button" class="btn btn-secondary">create race</button>-->
                    <!--<button type="button" class="btn btn-warning">progress</button>-->

                    
                    <a href="{{ route('create') }}" class="btn btn-secondary @if (!$canAddNewRace) disabled @endif">create race</a>
                    <a href="{{ route('progress') }}" class="btn btn-warning" title="Move all horses by 10 seconds">progress</a>
                </div>
            </nav>

            <div class="row">
                <div class="col-md-12 content">
                    @yield('content')
                </div>
            </div>

            <div class="row bottom">
                <div class="col-md-12">
                    <p>Copyright {{ date('Y') }} Michael Dymecki. Made on ThinkPad X230 :)</p>
                </div>
            </div>
        </div>
    </body>
</html>
