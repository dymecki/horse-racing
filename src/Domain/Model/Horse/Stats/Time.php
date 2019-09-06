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

    public static function obj(float $seconds = 0.0): self
    {
        return new self($seconds);
    }

    public function value(): float
    {
        return $this->seconds;
    }

    public function forwardedBy(self $seconds): self
    {
        return new self($this->seconds + $seconds->value());
    }

    public function cut(self $time): self
    {
        return new self($this->seconds - $time->value());
    }

    public function greater(self $time): bool
    {
        return $this->seconds > $time->value();
    }

    public function formatted(): string
    {
        [$whole, $decimal] = sscanf((string) $this->seconds, '%d.%d');

        return gmdate('i:s.', (int) $this->seconds) . ($decimal ?: '00');
    }

    public function __toString()
    {
        return (string) $this->seconds;
    }
}
