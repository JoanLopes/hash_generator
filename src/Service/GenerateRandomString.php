<?php

declare(strict_types=1);

namespace App\Service;

class GenerateRandomString
{
    public const RANDOM_BYTES_LENGTH = 4;

    public function getRandomString(): string
    {
        $bytes = random_bytes(self::RANDOM_BYTES_LENGTH);
        return bin2hex($bytes);
    }
}
