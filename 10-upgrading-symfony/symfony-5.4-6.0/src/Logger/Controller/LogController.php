<?php

declare(strict_types=1);

namespace App\Logger\Controller;

use Psr\Log\LoggerInterface;
use Symfony\Component\HttpFoundation\Response;

final class LogController
{
    public function __construct(private LoggerInterface $logger)
    {
    }

    public function log(): Response
    {
        $this->logger->debug('debug');
        $this->logger->error('error');

        return new Response('<body>ok</body>');
    }
}