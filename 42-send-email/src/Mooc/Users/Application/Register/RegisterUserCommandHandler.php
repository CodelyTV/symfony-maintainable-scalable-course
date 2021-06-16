<?php

declare(strict_types=1);

namespace CodelyTv\Mooc\Users\Application\Register;

use CodelyTv\Mooc\Users\Domain\UserEmail;
use CodelyTv\Mooc\Users\Domain\UserId;
use CodelyTv\Shared\Domain\Bus\Command\CommandHandler;

final class RegisterUserCommandHandler implements CommandHandler
{
    public function __construct(private RegisterUser $registerUser)
    {
    }

    public function __invoke(RegisterUserCommand $command): void
    {
        $id       = new UserId($command->id());
        $email     = new UserEmail($command->email());

        $this->registerUser->__invoke($id, $email);
    }
}