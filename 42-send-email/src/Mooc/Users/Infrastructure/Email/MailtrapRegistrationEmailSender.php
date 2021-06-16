<?php

declare(strict_types=1);

namespace CodelyTv\Mooc\Users\Infrastructure\Email;

use CodelyTv\Mooc\Users\Domain\RegistrationEmailSender;
use CodelyTv\Mooc\Users\Domain\User;
use Symfony\Component\Mailer\MailerInterface;
use Symfony\Component\Mime\Email;

final class MailtrapRegistrationEmailSender implements RegistrationEmailSender
{
    public function __construct(private MailerInterface $mailer)
    {
    }

    public function sendTo(User $user)
    {
        $email = (new Email())
            ->from('hello@codely.tv')
            ->to($user->email()->value())
            ->subject('Welcome to Codely')
            ->html('<p>Welcome to Codely :)</p>');

        $this->mailer->send($email);
    }
}