<?php

declare(strict_types=1);

namespace App\VarDumper\Controller;

use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Mailer\MailerInterface;

final class VarDumpController
{
    public function __construct(private MailerInterface $mailer)
    {
    }

    public function __invoke(): Response
    {
        dump($this->mailer);
        die;

        return new Response('ok');
    }
}