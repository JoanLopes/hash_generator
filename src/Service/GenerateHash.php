<?php

declare(strict_types=1);

namespace App\Service;

use Exception;

class GenerateHash
{
    public function getPrefixedHash(string $input): array
    {
        $generateRandomString = new GenerateRandomString();
        $counter = 0;
        do {
            $strKey = $generateRandomString->getRandomString();
            $hash = md5($input.$strKey);
            $match = preg_match('/\b0000/', $hash);
            $counter++;
        } while ($match == false);

        return [
            'hash' => $hash,
            'key' => $strKey,
            'numberOfAttempts' => $counter
        ];
    }
}
