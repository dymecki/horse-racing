<?php

declare(strict_types = 1);

namespace App\Domain\Model\Race;

use Ramsey\Uuid\Uuid;

final class RaceId
{
    private $id;

    public function __construct(string $id)
    {
        if (!$id) {
            throw new \InvalidArgumentException('Race id cannot be negative');
        }

        $this->id = $id;
    }

    public static function init()
    {
        return new self(Uuid::uuid4()->toString());
    }

    public function value(): string
    {
        return $this->id;
    }

    public function __toString()
    {
        return (string) $this->id;
    }
}
