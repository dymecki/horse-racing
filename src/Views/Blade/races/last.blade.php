@extends('layout')

@section('title', 'Last 5 races')

@section('content')

    <h1>Last 5 races</h1>

    <p>Best three horses in every of last five races.</p>

    @if ($races)
        <div class="accordion" id="last-races">

            @foreach ($races as $race)
                <div class="card">
                    <div
                            class="card-header"
                            id="heading-{{ $race->name }}"
                            data-toggle="collapse"
                            data-target="#collapse-{{ $race->name }}"
                            aria-expanded="true"
                            aria-controls="collapse-{{ $race->name }}"
                            style="cursor: pointer;"
                    >
                        <h2 class="mb-0 align-baseline">
                            <span class="h6">Race {{ $race->name }} - {{ $race->distance }}m</span>
                        </h2>
                    </div>

                    <div
                            id="collapse-{{ $race->name }}"
                            class="collapse @if ($loop->first) show @endif"
                            aria-labelledby="heading-{{ $race->name }}"
                            data-parent="#last-races"
                    >
                        <div class="card-body">
                            <table class="table table-striped">
                                <thead>
                                <tr>
                                    <th scope="col">Position</th>
                                    <th scope="col">Horse id</th>
                                    <th scope="col">Time</th>
                                </tr>
                                </thead>
                                <tbody>

                                @foreach ($race->horseRuns as $horse)
                                    <tr>
                                        <td>{{ $horse->position }}</td>
                                        <td>{{ $horse->name }}</td>
                                        <td>{{ $horse->time }}</td>
                                    </tr>
                                @endforeach

                                </tbody>
                            </table>
                        </div>
                    </div>
                </div>
            @endforeach

        </div>
    @else
        <div class="alert alert-primary" role="alert">
            Results will be shown when at least one race is completed
        </div>
    @endif

@endsection
