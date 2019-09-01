@extends('layout')

@section('content')

<h1>Last 5 races</h1>

@foreach ($races as $race)
<h6>Race {{ $race->name }}</h6>

<table class="table table-striped table-sm">
    <thead>
        <tr>
            <th scope="col">Horse id</th>
            <th scope="col">Distance covered</th>
            <th scope="col">Time</th>
        </tr>
    </thead>
    <tbody>

        @foreach ($race->runningHorses as $horse)
        <tr>
            <td>{{ $horse->name }}</td>
            <td>
                <div class="progress">
                    <div
                        class="progress-bar progress-bar-striped bg-success"
                        role="progressbar"
                        style="width: {{ $horse->distanceCovered }}%"
                        aria-valuenow="{{ $horse->distanceCovered }}"
                        aria-valuemin="0"
                        aria-valuemax="100">{{ $horse->distanceCovered }}
                    </div>
                </div>
            </td>
            <td>{{ $horse->time }} s</td>
        </tr>
        @endforeach

    </tbody>
</table>

@endforeach
@endsection
