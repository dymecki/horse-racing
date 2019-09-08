@extends('layout')

@section('content')

    @if ($bestHorseEver)
        <div class="card mb-3">
            <div class="card-header">
                Best horse ever
            </div>
            <div class="card-body">
                @if ($bestHorseEver->id)
                    <table class="table" style="margin: 0;">
                        <thead>
                        <tr>
                            <th scope="col">Horse</th>
                            <th scope="col">Speed</th>
                            <th scope="col">Strength</th>
                            <th scope="col">Endurance</th>
                            <th scope="col">Time</th>
                        </tr>
                        </thead>
                        <tbody>
                        <tr>
                            <td>{{ $bestHorseEver->name }}</td>
                            <td>{{ $bestHorseEver->speed }}</td>
                            <td>{{ $bestHorseEver->strength }}</td>
                            <td>{{ $bestHorseEver->endurance }}</td>
                            <td>{{ $bestHorseEver->time }}</td>
                        </tr>
                        </tbody>
                    </table>
                @else
                    Best horse's stats will be shown when at least one race is completed
                @endif
            </div>
        </div>
    @endif

    @if ($races)
        <h5>Current races</h5>

        <div class="accordion" id="current-races">
            @foreach ($races as $race)
                @include('races._race', ['race' => $race])
            @endforeach
        </div>
    @else
        <div class="alert alert-primary" role="alert">
            No active races. Create first race.
        </div>
    @endif

@endsection
