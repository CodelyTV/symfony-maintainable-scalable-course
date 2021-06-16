<?php

declare(strict_types=1);

namespace CodelyTv\Mooc\Users\Application\SendRegistrationEmail;

use CodelyTv\Mooc\Users\Domain\UserId;
use CodelyTv\Mooc\Users\Domain\UserNotExist;
use CodelyTv\Mooc\Users\Domain\UserRepository;

final class RegistrationEmailSender
{
    public function __construct(
        private UserRepository $userRepository,
        private \CodelyTv\Mooc\Users\Domain\RegistrationEmailSender $sender
    ) {
    }

    public function send(string $userId)
    {
        $userId = new UserId($userId);
        $user = $this->userRepository->search($userId);

        if (!$user) {
            throw new UserNotExist($userId);
        }

        $this->sender->sendTo($user);
    }
}