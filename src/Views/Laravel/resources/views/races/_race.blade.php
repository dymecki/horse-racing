
<!--<h4>Race {{ $race->name }} <span class="badge badge-secondary">{{ $race->time }}</span></h4>-->

<div class="card text-white bg-dark mb-3">
    <div class="card-header">
        Race {{ $race->name }} <span class="badge badge-secondary">{{ $race->time }}</span>
    </div>
    <div class="card-body" style="background-color: transparent">
        <!--<h5 class="card-title">Special title treatment</h5>-->
        
        <!--<p class="card-text">With supporting text below as a natural lead-in to additional content.</p>-->

        <table class="table table-striped table-sm table-borderless table-dark">
            <thead class="thead-dark">
                <tr>
                    <th scope="col" style="width: 10%;">Position</th>
                    <th scope="col" style="width: 20%;">Horse</th>
                    <th scope="col" style="width: 70%;">Distance covered</th>
                </tr>
            </thead>
            <tbody>

                @foreach ($race->horseRuns as $horse)
                <tr>
                    <td>{{ $horse->position }}</td>
                    <td>{{ $horse->name }}</td>
                    <td>
                        <div class="progress">
                            <div
                                class="progress-bar progress-bar-striped bg-success _progress-bar-animated"
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
