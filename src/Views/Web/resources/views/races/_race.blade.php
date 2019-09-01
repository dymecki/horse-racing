
<!--<h4>Race {{ substr($race->id(), 0, 8) }} <span class="badge badge-secondary">{{ $race->time() }}</span></h4>-->

<div class="card text-white bg-dark mb-3">
    <div class="card-header">
        Race {{ substr($race->id(), 0, 8) }} <span class="badge badge-secondary">{{ $race->time() }}</span>
    </div>
    <div class="card-body" style="background-color: transparent">
        <h5 class="card-title">Special title treatment</h5>
        
        <p class="card-text">With supporting text below as a natural lead-in to additional content.</p>

        <table class="table table-striped table-sm table-borderless table-dark">
            <thead class="thead-dark">
                <tr>
                    <th scope="col">Horse</th>
                    <th scope="col">Position</th>
                    <th scope="col">Distance covered</th>
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
                                class="progress-bar progress-bar-striped bg-success _progress-bar-animated"
                                role="progressbar"
                                style="width: {{ $horse->stats()->distanceCovered()->value() / $race->distance()->value() * 100 }}%"
                                aria-valuenow="{{ $horse->stats()->distanceCovered() }}"
                                aria-valuemin="0"
                                aria-valuemax="100">{{ $horse->stats()->distanceCovered() }}
                            </div>
                        </div>
                    </td>
                </tr>
                @endforeach

            </tbody>
        </table>
    </div>
</div>
