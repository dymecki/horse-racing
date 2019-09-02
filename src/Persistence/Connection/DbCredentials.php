<?php

declare(strict_types = 1);

namespace App\Persistence\Connection;

final class DbCredentials
{
    private $host;
    private $name;
    private $user;
    private $password;

    public function __construct(
        string $host,
        string $name,
        string $user,
        string $password
    ){
        $this->host     = $host;
        $this->name     = $name;
        $this->user     = $user;
        $this->password = $password;
    }

    public function user(): string
    {
        return $this->user;
    }

    public function name(): string
    {
        return $this->name;
    }

    public function host(): string
    {
        return $this->host;
    }

    public function password(): string
    {
        return $this->password;
    }

    public function driver(): string
    {
        return 'pgsql';
    }

    public function dsn(): string
    {
        return \sprintf(
            '%s:host=%s;dbname=%s',
            $this->driver(),
            $this->host(),
            $this->name()
        );
    }

    public function __toString()
    {
        return $this->dsn();
    }
}
