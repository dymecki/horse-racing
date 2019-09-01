@extends('layout')

@section('content')

<h3>Race {{ $race->race_id }}</h3>

<table class="table table-striped table-sm">
    <thead>
        <tr>
            <th scope="col">Horse id</th>
            <th scope="col">Distance covered</th>
            <th scope="col">Time</th>
        </tr>
    </thead>
    <tbody>

        @foreach ($race->horses() as $horse)
        <tr>
            <td>{{ $horse->name }}</td>
            <td>
                <div class="progress">
                    <div
                        class="progress-bar progress-bar-striped bg-success"
                        role="progressbar"
                        style="width: {{ $horse->distance_covered }}%"
                        aria-valuenow="{{ $horse->distance_covered }}"
                        aria-valuemin="0"
                        aria-valuemax="100">
                    </div>
                </div>
            </td>
            <td>{{ $horse->time }} s</td>
        </tr>
        @endforeach

    </tbody>
</table>

@endsection
