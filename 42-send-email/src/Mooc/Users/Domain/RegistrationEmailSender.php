<?php

declare(strict_types=1);

namespace CodelyTv\Mooc\Users\Domain;

interface RegistrationEmailSender
{
    public function sendTo(User $user);
}