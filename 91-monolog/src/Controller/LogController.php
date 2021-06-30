<?php

declare(strict_types=1);

namespace App\Controller;

use Psr\Log\LoggerInterface;
use Psr\Log\LogLevel;
use Symfony\Component\HttpFoundation\Response;

final class LogController
{
    public function __construct(private LoggerInterface $logger)
    {
    }

    public function __invoke(): Response
    {
        $this->logger->log(LogLevel::WARNING, 'Warning from Controller!');

        return new Response('ok');
    }
}