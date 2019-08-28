<?php

declare(strict_types = 1);

namespace App\Persistence\Connection;

use App\Persistence\Connection\DbCredentialsFactory;

final class DbCredentials
{
    private $host;
    private $name;
    private $user;
    private $password;
    private $charset;

    public function __construct(
        string $host,
        string $name,
        string $user,
        string $password,
        string $charset
    ){
        $this->host     = $host;
        $this->name     = $name;
        $this->user     = $user;
        $this->password = $password;
        $this->charset  = $charset;
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
        return $this->driver() . ':host=' . DbCredentialsFactory::HOST . ';dbname=' . DbCredentialsFactory::NAME;
    }

    public function __toString()
    {
        return $this->dsn();
    }

}
