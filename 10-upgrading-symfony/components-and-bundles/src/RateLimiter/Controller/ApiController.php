<?php

declare(strict_types=1);

namespace App\RateLimiter\Controller;

use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\HttpKernel\Exception\TooManyRequestsHttpException;
use Symfony\Component\RateLimiter\RateLimiterFactory;

final class ApiController
{
    public function __construct(private RateLimiterFactory $anonymousApiLimiter)
    {
        
    }
    
    public function __invoke(Request $request): Response
    {
        $limiter = $this->anonymousApiLimiter->create($request->getClientIp());
        $limit = $limiter->consume(1);
        $headers = [
            'X-RateLimit-Remaining' => $limit->getRemainingTokens(),
            'X-RateLimit-Retry-After' => $limit->getRetryAfter()->getTimestamp(),
            'X-RateLimit-Limit' => $limit->getLimit(),
        ];

        if (false === $limit->isAccepted()) {
            throw new TooManyRequestsHttpException(null, '', null, 0, $headers);
        }

        $response = new JsonResponse('{}');
        $response->headers->add($headers);
        return $response;
    }
}