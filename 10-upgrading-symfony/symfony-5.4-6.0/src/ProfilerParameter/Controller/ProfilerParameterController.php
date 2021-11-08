<?php

declare(strict_types=1);

namespace App\ProfilerParameter\Controller;

use Symfony\Component\HttpFoundation\Response;

final class ProfilerParameterController
{
    public function __construct()
    {
    }

    public function index(): Response
    {
        return new Response('<body>ok</body>');
    }
}