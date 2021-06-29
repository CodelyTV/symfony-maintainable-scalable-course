<?php

declare(strict_types=1);

namespace App\Controller;

use Lexik\Bundle\JWTAuthenticationBundle\Encoder\JWTEncoderInterface;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Mailer\MailerInterface;
use Symfony\Component\Mime\Email;

final class SendCertificatePostController
{
    public function __construct(
        private JWTEncoderInterface $jwtEncoder,
        private MailerInterface $mailer
    ) {
    }

    public function __invoke(): Response
    {
        $token = $this->jwtEncoder->encode([
            'student_id' => '5',
            'course_id' => '3'
        ]);

        $email = (new Email())
            ->from('hello@codely.tv')
            ->to('dani@codely.tv')
            ->subject('Codely course certification!')
            ->html("<p><a href=\"http://localhost:8000/certificate?cert=$token\">View certificate</a></p>");
        $this->mailer->send($email);

        return new JsonResponse(['token' => $token]);
    }
}