<?php

declare(strict_types = 1);

namespace App\Persistence\Dao\Mappers;

use App\Domain\Model\Race\RunningHorse;

final class HorseMapper
{
    private $data;

    public function __construct($data)
    {
        $this->data = $data;
    }

    public function get(): RunningHorse
    {
        return RunningHorse::create($this->data);
    }
}
