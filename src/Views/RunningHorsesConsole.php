<?php

declare(strict_types = 1);

namespace App\Views;

final class RunningHorsesConsole
{
    private $horses;

    public function __construct(array $horses)
    {
        $this->horses = $horses;
    }

    public function __toString()
    {
        $result = '';

        foreach ($this->horses as $horse) {
            $result .= $horse . "\n";
        }

        return $result . "\n\n";
    }
}
