<?php

declare(strict_types=1);

namespace CodelyTv\Mooc\Users\Infrastructure\Email;

use CodelyTv\Mooc\Users\Domain\RegistrationEmailSender;
use CodelyTv\Mooc\Users\Domain\User;

final class InMemoryRegistrationEmailSender implements RegistrationEmailSender
{
    private array $users = [];

    public function sendTo(User $user)
    {
        $this->users[$user->id()->value()] = $user;
    }

    public function userWithPendingRegistrationEmail(): array
    {
        return $this->users;
    }
}