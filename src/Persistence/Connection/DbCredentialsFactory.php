<?php

declare(strict_types = 1);

namespace App\Persistence\Connection;

use App\Persistence\Connection\DbCredentials;

final class DbCredentialsFactory
{
    public static function build(): DbCredentials
    {
        return new DbCredentials(
            \getenv('DB_HOST'),
            \getenv('DB_NAME'),
            \getenv('DB_USER'),
            \getenv('DB_PASS')
        );
    }
}
