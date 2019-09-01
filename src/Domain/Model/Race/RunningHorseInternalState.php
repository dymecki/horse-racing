<?php

declare(strict_types = 1);

namespace App\Domain\Model\Race;

final class RunningHorseInternalState
{
    private $horse;

    public function __construct(RunningHorse $horse)
    {
        $this->horse = $horse;
    }

    public function data(): array
    {
        $horse  = $this->horse;

        return [
            'id'                => $horse->horse()->id(),
            'speed'             => $horse->horse()->stats()->speed(),
            'strength'          => $horse->horse()->stats()->strength(),
            'endurance'         => $horse->horse()->stats()->endurance(),
            'distance'          => $horse->stats()->distance(),
            'fullSpeedDistance' => $horse->fullSpeedDistance(),
            'time'              => $horse->stats()->time(),
            'secondsPerMeter'   => $horse->horse()->stats()->speed()->secondsPerMeter()
        ];
    }

    public function __toString()
    {
        return json_encode($this->data(), JSON_PRETTY_PRINT);
    }
}
