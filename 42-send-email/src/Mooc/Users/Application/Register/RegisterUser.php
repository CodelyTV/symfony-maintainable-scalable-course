<?php

declare(strict_types=1);

namespace CodelyTv\Mooc\Users\Application\Register;

use CodelyTv\Mooc\Users\Domain\RegistrationEmailSender;
use CodelyTv\Mooc\Users\Domain\User;
use CodelyTv\Mooc\Users\Domain\UserEmail;
use CodelyTv\Mooc\Users\Domain\UserId;
use CodelyTv\Mooc\Users\Domain\UserRepository;
use CodelyTv\Shared\Domain\Bus\Event\EventBus;

final class RegisterUser
{
    public function __construct(
        private UserRepository $repository,
        private RegistrationEmailSender $registrationEmailSender,
        private EventBus $bus
    ) {
    }

    public function __invoke(UserId $id, UserEmail $email): void
    {
        $user = User::register($id, $email);

        $this->repository->save($user);
        $this->bus->publish(...$user->pullDomainEvents());
    }
}