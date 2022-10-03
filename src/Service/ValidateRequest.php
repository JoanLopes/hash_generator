<?php

declare(strict_types=1);

namespace App\Service;

class ValidateRequest
{

    public function tooManyAttempts($limiter): array|null
    {
        if (false === $limiter->consume()->isAccepted()) {
            $msg = 'Too Many Attempts';
            return [
                'message' => $msg,
                'status-code' => 429
            ];
        }
        return null;
    }

    public function fieldExists(array $arr): array|null
    {
        if (!isset($arr['str'])) {
            $msg = "Error: Required field str is missing or empty";
            return [
                'message'=>$msg,
                'status-code' => 400,
            ];
        }
        return null;
    }
}