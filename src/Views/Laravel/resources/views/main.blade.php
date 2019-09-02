@extends('layout')

@section('content')

<div class="card mb-3">
    <div class="card-header">
        Best horse ever
    </div>
    <div class="card-body">
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
                    <td>{{ $bestHorseEver->time }} s</td>
                </tr>
            </tbody>
        </table>
    </div>
</div>

@each('races._race', $races, 'race')

{{-- <form action="" method="post">
    @csrf
    <button>progress</button>
    <input type="submit" value="create race"/>
</form> --}}

@endsection
