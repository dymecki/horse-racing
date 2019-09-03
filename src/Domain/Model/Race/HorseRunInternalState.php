<?php

declare(strict_types = 1);

namespace App\Domain\Model\Race;

final class HorseRunInternalState
{
    private $horse;

    public function __construct(HorseRun $horse)
    {
        $this->horse = $horse;
    }

    public function data(): array
    {
        $run             = $this->horse;
        $speed           = $run->speed();
        $secondsPerMeter = $speed->time()->value() / $speed->distance()->value();
        $metersPerSecond = $speed->distance()->value() / $speed->time()->value();

        return [
            'id'                => $run->horse()->id()->value(),
            'speed'             => $run->speed()->distance()->value(),
            'strength'          => $run->horse()->stats()->strength()->value(),
            'endurance'         => $run->horse()->stats()->endurance()->value(),
            'distance_covered'  => $run->stats()->distanceCovered()->value(),
            'fullSpeedDistance' => $run->fullSpeedDistance()->value() . ' m',
            'time'              => $run->stats()->time()->value(),
            'secondsPerMeter'   => number_format($secondsPerMeter, 2),
            'metersPerSecond'   => $metersPerSecond,
            'isTired'           => $run->isTired()
        ];
    }

    public function __toString()
    {
        return (string) json_encode($this->data(), JSON_PRETTY_PRINT);
    }
}
