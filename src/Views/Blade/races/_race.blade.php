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

            <span
                    class="badge badge-secondary float-right"
                    data-toggle="tooltip"
                    data-placement="left"
                    title="Current time"
                    style="font-weight: normal;">{{ $race->time }}
            </span>
        </h2>
    </div>

    <div
            id="collapse-{{ $race->name }}"
            class="collapse @if ($loop->first) show @endif"
            aria-labelledby="heading-{{ $race->name }}"
            data-parent="#current-races"
    >
        <div class="card-body">
            <table class="table table-striped table-hover" style="margin: 0;">
                <thead>
                <tr>
                    <th scope="col" style="width: 20%;">Position</th>
                    <th scope="col" style="width: 20%;">Horse</th>
                    <th scope="col" style="width: 60%;">Distance covered</th>
                </tr>
                </thead>
                <tbody>

                @foreach ($race->horseRuns as $horse)
                    <tr>
                        <td>{{ $horse->position }}</td>
                        <td title="Speed: {{ $horse->speed }}, Strength: {{ $horse->strength }}, Endurance: {{$horse->endurance}}, FSD: {{ $horse->fullSpeedDistance }}">{{ $horse->name }}</td>
                        <td>
                            <div class="progress">
                                <div
                                        class="progress-bar progress-bar-striped bg-success"
                                        role="progressbar"
                                        style="width: {{ $horse->distanceCovered / $race->distance * 100 }}%"
                                        aria-valuenow="{{ $horse->distanceCovered / $race->distance * 100 }}"
                                        aria-valuemin="0"
                                        aria-valuemax="100">{{ $horse->distanceCovered }} m
                                </div>
                            </div>
                        </td>
                    </tr>
                @endforeach

                </tbody>
            </table>
        </div>
    </div>
</div>
