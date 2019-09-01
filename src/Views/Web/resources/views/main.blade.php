@extends('layout')

@section('content')

@each('races._race', $races, 'race')

{{-- <form action="" method="post">
    @csrf
    <button>progress</button>
    <input type="submit" value="create race"/>
</form> --}}

{{--
<div class="">
    <h3>All races</h3>

    <table class="table table-striped table-sm">
        <thead>
            <tr>
                <th scope="col">Race id</th>
                <th scope="col">Distance</th>
                <th scope="col">Best time</th>
            </tr>
        </thead>
        <tbody>

            @foreach ($races as $race)
                <tr>
                    <td><a href="{{ route('races.show', ['id' => $race->id()]) }}" title="Show race's details">{{ substr($race->id(), 0, 8)}}</a></td>
                    <td>{{ $race->distance()}}</td>
                    <td></td>
                </tr>
            @endforeach

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
                <th scope="col">Covered dist</th>
            </tr>
        </thead>
        <tbody>

            @foreach ($horses as $horse)
                <tr>
                    <td>{{ substr($horse->horse_id, 0, 8)}}</td>
                    <td>{{ $horse->speed}}</td>
                    <td>{{ $horse->strength}}</td>
                    <td>{{ $horse->endurance}}</td>
                    <td>{{ $horse->distance_covered}} m</td>
                </tr>
            @endforeach

        </tbody>
    </table>
</div>
--}}

@endsection
