<?php

declare(strict_types=1);

namespace App\Controller;

use Psr\Log\LoggerInterface;
use Symfony\Component\HttpFoundation\Response;

final class LogController
{
    public function __construct(private LoggerInterface $logger)
    {
    }

    public function __invoke(): Response
    {
        $this->logUserDoesNotExist(123);
        $this->logUserDoesNotExist(456);
        $this->logUserDoesNotExist(789);

        return new Response('ok');
    }

    protected function logUserDoesNotExist(int $userId): void
    {
        $this->logger->error("User does not exist", ['user_id' => $userId]);
    }
}