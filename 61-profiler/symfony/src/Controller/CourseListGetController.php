<?php

declare(strict_types=1);

namespace App\Controller;

use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Response;

final class CourseListGetController
{
    public function __invoke(): Response
    {
        return new JsonResponse([
            [
                'id' => 1,
                'title' => 'Arquitectura Hexagonal'
            ],
            [
                'id' => 2,
                'title' => 'JS Moderno'
            ]
        ]);
    }
}