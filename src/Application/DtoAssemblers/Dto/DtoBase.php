<?php

declare(strict_types = 1);

namespace App\Application\DtoAssemblers\Dto;

abstract class DtoBase
{
    public function __construct()
    {
        foreach ($this as $key => $value) {
            if ($value === null) {
                throw new \InvalidArgumentException("$key cannot be empty");
            }
        }
    }

    public function __set($name, $value)
    {

    }
}
