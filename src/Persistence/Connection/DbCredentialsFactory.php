<?php

declare(strict_types = 1);

namespace App\Persistence\Connection;

use App\Persistence\Connection\DbCredentials;

final class DbCredentialsFactory
{
    public static function build(): DbCredentials
    {
        return new DbCredentials(
            (string) \getenv('DB_HOST'),
            (string) \getenv('DB_NAME'),
            (string) \getenv('DB_USER'),
            (string) \getenv('DB_PASS')
        );
    }
}
