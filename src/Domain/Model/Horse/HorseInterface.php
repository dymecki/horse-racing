<?php

declare(strict_types = 1);

namespace App\Domain\Model\Horse;

interface HorseInterface
{

    public function name(): Name;

    public function speed(): Speed;

    public function strength(): Strength;

    public function endurance(): Endurance;

    public function distance(): Distance;
}
