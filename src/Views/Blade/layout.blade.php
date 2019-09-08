<!doctype html>
<html>
<head>
    <meta charset="utf-8">
    <title>@yield('title', 'Horse Racing Simulator')</title>
    <meta name="viewport" content="width=device-width, initial-scale=1.0"/>
    <meta name="robots" content="noindex"/>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/twitter-bootstrap/4.3.1/css/bootstrap.min.css"/>

    <script src="https://cdnjs.cloudflare.com/ajax/libs/jquery/3.4.1/jquery.slim.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/twitter-bootstrap/4.3.1/js/bootstrap.bundle.min.js"></script>
    <script>
        $('#current-races').collapse('show');

        $(function () {
            $('[data-toggle="tooltip"]').tooltip();
        });
    </script>

    <style>
        .container nav.navbar {
            margin-bottom: 20px;
        }

        .bottom {
            border-top: 1px solid #efefef;
            color: #909090;
            font-size: 0.8em;
            padding: 30px;
            text-align: center;
        }

        .progress {
            background-color: rgba(0, 0, 0, 0.05);
            height: auto;
            -webkit-box-shadow: none;
            box-shadow: none;
            text-shadow: #303030 1px 1px 3px;
        }

        .table-hover > tbody > tr:hover {
            background-color: lightyellow;
        }

        .accordion .card-header:hover {
            background: rgba(0, 0, 0, 0.06);
        }
    </style>
</head>
<body class="_bg-dark">
<div class="container _container-fluid">
    <nav class="navbar navbar-expand-lg navbar-dark bg-dark">
        <a href="index" class="navbar-brand">Horse Racing Simulator</a>

        <button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#navbarNavAltMarkup"
                aria-controls="navbarNavAltMarkup" aria-expanded="false" aria-label="Toggle navigation">
            <span class="navbar-toggler-icon"></span>
        </button>

        <div class="collapse navbar-collapse" id="navbarNavAltMarkup">
            <div class="navbar-nav">
                <a href="/" class="nav-item nav-link _active">Home <span class="sr-only">(current)</span></a>
                <a href="last-races.php" class="nav-item nav-link">Last 5 races</a>
            </div>
        </div>

        <div class="btn-group float-right" role="group" aria-label="Basic example">
            {{-- <form action="" method="post">
                @csrf
                <button type="button" class="btn btn-secondary">create race</button>
                <button type="button" class="btn btn-warning">progress</button>
            </form> --}}

            <a href="create-race.php" class="btn btn-info @if (!$canAddNewRace) disabled @endif">create race</a>
            <a href="progress.php"
               class="btn btn-info @if (!$canProgress) disabled @endif"
               title="Advance all horses by 10 seconds"
               data-toggle="tooltip"
               data-placement="bottom"
            >progress</a>
        </div>
    </nav>

    <div class="row">
        <div class="col-md-12 content" style="padding-bottom: 20px;">
            @yield('content')
        </div>
    </div>

    <div class="navbar bottom">
        <div class="col-md-12">
            <p sty>Copyright {{ date('Y') }} by Michael Dymecki. Made on ThinkPad X230</p>
        </div>
    </div>
</div>
</body>
</html>
