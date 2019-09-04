<?php

declare(strict_types = 1);

namespace App\Domain\Model\Horse\Stats;

final class Time
{
    private $seconds;

    public function __construct(float $seconds = 0.0)
    {
        if ($seconds < 0) {
            throw new \InvalidArgumentException('Seconds amount cannot be negative');
        }

        $this->seconds = $seconds;
    }

    public function value(): float
    {
        return $this->seconds;
    }

    public function withAdd(float $seconds): self
    {
        return new self($this->seconds + $seconds);
    }

    public function formatted(): string
    {
        return gmdate('H:i:s', (int) $this->seconds);
    }

    public function __toString()
    {
        return (string) $this->seconds;
    }
}
