<?php

declare(strict_types = 1);

namespace App\Domain\Model\Horse;

use Ramsey\Uuid\Uuid;

final class HorseId
{
    private $id;

    public function __construct(string $id)
    {
        if (!$id) {
            throw new \InvalidArgumentException('Horse id cannot be empty');
        }

        $this->id = $id;
    }

    public static function obj(): self
    {
        return new self(Uuid::uuid4()->toString());
    }

    public static function fromString(string $id): self
    {
        return new self($id);
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
