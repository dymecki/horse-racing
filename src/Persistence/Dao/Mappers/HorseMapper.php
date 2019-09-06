<?php

declare(strict_types = 1);

namespace App\Persistence\Dao\Mappers;

use App\Domain\Model\Race\HorseRun;

final class HorseMapper
{
    private $data;

    public function __construct($data)
    {
        $this->data = $data;
    }

    public function get(): HorseRun
    {
        return HorseRun::obj($this->data);
    }
}
