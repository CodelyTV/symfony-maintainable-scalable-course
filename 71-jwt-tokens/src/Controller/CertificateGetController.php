<?php

declare(strict_types=1);

namespace App\Controller;

use Lexik\Bundle\JWTAuthenticationBundle\Encoder\JWTEncoderInterface;
use Lexik\Bundle\JWTAuthenticationBundle\Exception\JWTDecodeFailureException;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpKernel\Exception\NotFoundHttpException;

final class CertificateGetController
{
    public function __construct(private JWTEncoderInterface $jwtEncoder)
    {
    }

    public function __invoke(Request $request): JsonResponse
    {
        $token = $request->query->get('cert');

        if (!$token) {
            throw new NotFoundHttpException();
        }

        try {
            $data = $this->jwtEncoder->decode($token);
        } catch (JWTDecodeFailureException $exception) {
            throw new NotFoundHttpException();
        }

        $response = [
            'studentId' => $data['student_id'],
            'courseId' => $data['course_id'],
        ];

        return new JsonResponse($response);
    }
}