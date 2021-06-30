<?php

declare(strict_types=1);

namespace App\Controller;

use Psr\Log\LoggerInterface;
use Symfony\Component\HttpFoundation\Response;

final class ErrorController
{
    public function __construct(private LoggerInterface $logger)
    {
    }

    public function __invoke(): Response
    {
        $this->logger->info('Info');
        // $this->logger->error('Error from Controller!');

        return new Response('ok');
    }
}