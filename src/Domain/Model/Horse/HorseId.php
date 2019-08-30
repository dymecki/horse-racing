<?php

declare(strict_types = 1);

namespace App\Domain\Model\Horse;

final class HorseId
{
    private $id;

    public function __construct(int $id)
    {
        if ($id < 0) {
            throw new InvalidArgumentException('Horse id cannot be negative');
        }

        $this->id = $id;
    }

    public function value(): int
    {
        return $this->id;
    }

    public function __toString()
    {
        return (string) $this->id;
    }
}
