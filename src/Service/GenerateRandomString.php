<?php

declare(strict_types=1);

namespace App\Service;

use Exception;

class GenerateRandomString
{
    public const RANDOM_BYTES_LENGTH = 4;

    /**
     * @throws Exception
     */
    public function getRandomString(): string
    {
        $bytes = random_bytes(self::RANDOM_BYTES_LENGTH);
        return bin2hex($bytes);
    }
}
