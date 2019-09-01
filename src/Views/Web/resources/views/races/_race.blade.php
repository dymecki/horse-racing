<h4>Race {{ substr($race->id(), 0, 8) }}</h4>

<table class="table _table-striped table-sm">
    <thead>
        <tr>
            <th scope="col">Horse id</th>
            <th scope="col">Position</th>
            <th scope="col">Distance covered</th>
            <th scope="col">Time</th>
        </tr>
    </thead>
    <tbody>

        @foreach ($race->horses() as $horse)
        <tr>
            <td>{{ substr($horse->horse()->id(), 0, 8) }}</td>
            <td></td>
            <td>
                <div class="progress">
                    <div
                        class="progress-bar progress-bar-striped bg-success"
                        role="progressbar"
                        style="width: {{ $horse->stats()->distance() }}%"
                        aria-valuenow="{{ $horse->stats()->distance() }}"
                        aria-valuemin="0"
                        aria-valuemax="100">
                    </div>
                </div>
            </td>
            <td>{{ $horse->stats()->time() }}</td>
        </tr>
        @endforeach

    </tbody>
</table>
