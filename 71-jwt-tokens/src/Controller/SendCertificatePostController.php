<?php

declare(strict_types=1);

namespace App\Controller;

use Lexik\Bundle\JWTAuthenticationBundle\Encoder\JWTEncoderInterface;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Response;

final class SendCertificatePostController
{
    public function __construct(private JWTEncoderInterface $jwtEncoder)
    {
    }

    public function __invoke(): Response
    {
        $token = $this->jwtEncoder->encode([
            'student_id' => '5',
            'course_id' => '3'
        ]);

        return new JsonResponse(['token' => $token]);
    }
}