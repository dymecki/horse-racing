<?php

declare(strict_types = 1);

namespace App\Domain\Model\Horse;

final class Name
{
    private $name;

    public function __construct(string $name)
    {
        if (strlen($name) < 2) {
            throw new \InvalidArgumentException('Name must be at least two characters long');
        }

        if (strlen($name) > 20) {
            throw new \InvalidArgumentException('Name must be max 20 characters long');
        }

        $this->name = $name;
    }

    public function value()
    {
        return $this->name;
    }

    public function __toString()
    {
        return $this->name;
    }
}
