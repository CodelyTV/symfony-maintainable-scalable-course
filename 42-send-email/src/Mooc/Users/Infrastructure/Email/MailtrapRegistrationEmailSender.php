<?php

declare(strict_types=1);

namespace CodelyTv\Mooc\Users\Infrastructure\Email;

use CodelyTv\Mooc\Users\Domain\RegistrationEmailSender;
use CodelyTv\Mooc\Users\Domain\User;

final class MailtrapRegistrationEmailSender implements RegistrationEmailSender
{
    public function sendTo(User $user)
    {
        sleep(5);
    }
}