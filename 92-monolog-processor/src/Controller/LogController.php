<?php

declare(strict_types=1);

namespace App\Controller;

use Psr\Log\LoggerInterface;
use Symfony\Component\HttpFoundation\Response;

final class LogController
{
    public function __construct(private LoggerInterface $domainEventLogger)
    {
    }

    public function __invoke(): Response
    {
        $this->domainEventLogger->warning('Warning from Controller!');

        return new Response('ok');
    }
}