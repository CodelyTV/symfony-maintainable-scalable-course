<?php

declare(strict_types=1);

namespace App\EmailPreview\Controller;

use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Mailer\MailerInterface;
use Symfony\Component\Mime\Email;

final class SendEmailController
{
    public function __construct(private MailerInterface $mailer)
    {
    }

    public function send(): Response
    {
        $emailHtml = file_get_contents(__DIR__ . '/email.html');
        $email = (new Email())
            ->from('info@codely.tv')
            ->to('example@codely.tv')
            ->subject('Email preview')
            ->text('Email preview')
            ->html($emailHtml);

        $this->mailer->send($email);

        return new Response('<body>ok</body>');
    }
}