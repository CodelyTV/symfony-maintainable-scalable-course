<?php

declare(strict_types=1);

namespace CodelyTv\Apps\Mooc\Backend\Controller\Users;

use CodelyTv\Mooc\Users\Application\Register\RegisterUserCommand;
use CodelyTv\Shared\Infrastructure\Symfony\ApiController;
use Symfony\Component\HttpFoundation\JsonResponse;

final class RegisterUserPutController extends ApiController
{
    public function __invoke(RegisterUserCommand $command): JsonResponse
    {
        $this->dispatch($command);

        return new JsonResponse();
    }

    protected function exceptions(): array
    {
        return [];
    }
}