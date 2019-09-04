<?php

declare(strict_types = 1);

namespace App\Application\Services;

use App\Persistence\Dao\HorseDao;
use App\Persistence\Dao\Mappers\HorseMapper;
use App\Application\DtoAssemblers\HorseDtoAssembler;
use App\Application\DtoAssemblers\Dto\HorseDto;

final class HorseService
{
    private $horse;

    public function __construct()
    {
        $this->horse = new HorseDao();
    }

    public function getBestHorseRunEver()
    {
        return $this->getDto($this->horse->getBestHorseRunEver());
    }

    private function getDto($horse): HorseDto
    {
        if (!$horse) {
            return new HorseDto();
        }

        return (new HorseDtoAssembler((new HorseMapper($horse))->get()))->writeDto();
    }
}
