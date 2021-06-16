<?php

declare(strict_types=1);

namespace CodelyTv\Apps\Mooc\Backend\Controller\Users;

use CodelyTv\Mooc\Users\Application\Register\RegisterUserCommand;
use CodelyTv\Shared\Infrastructure\Symfony\ApiController;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Request;

final class RegisterUserPutController extends ApiController
{
    public function __invoke(string $id, Request $request): JsonResponse
    {
        $this->dispatch(
            new RegisterUserCommand(
                $id,
                $request->request->get('email')
            )
        );

        return new JsonResponse();
    }

    protected function exceptions(): array
    {
        return [];
    }
}