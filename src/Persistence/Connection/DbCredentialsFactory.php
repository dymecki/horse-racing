<?php

declare(strict_types = 1);

namespace App\Persistence\Connection;

use App\Persistence\Connection\DbCredentials;

final class DbCredentialsFactory
{
    public const DRIVER  = 'pgsql';
    public const HOST    = 'localhost';
    public const NAME    = 'innogames';
    public const USER    = 'homestead';
    public const PASS    = 'secret';
    public const CHARSET = '';

    public static function build(): DbCredentials
    {
        return new DbCredentials(
            self::HOST, self::NAME, self::USER, self::PASS, self::CHARSET
        );
    }

}
