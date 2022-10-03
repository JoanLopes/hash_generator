<?php

declare(strict_types=1);

namespace App\Controller;

use App\Service\GenerateHash;
use App\Service\ValidateRequest;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\RateLimiter\RateLimiterFactory;
use Symfony\Component\Routing\Annotation\Route;

#[Route("/api")]
class GenerateHashController extends AbstractController
{
    #[Route(
        '/generate/hash',
        name: 'api_generate_hash',
        methods: ["POST"]
    )]
    public function generateHash(
        Request $request,
        RateLimiterFactory $apiGenerateHashLimiter
    ): JsonResponse
    {
        $generateHash = new GenerateHash();
        $validateRequest = new ValidateRequest();
        $arr = $request->toArray();
        $limiter = $apiGenerateHashLimiter->create($request->getClientIp());
        $fieldExists = $validateRequest->fieldExists($arr);
        $tooManyAttempts = $validateRequest->tooManyAttempts($limiter);
        $error = $fieldExists ?? $tooManyAttempts;

        return $error ?
            new JsonResponse($error['message'],$error['status-code']) :
            new JsonResponse($generateHash->getPrefixedHash($arr['str']));
    }
}
