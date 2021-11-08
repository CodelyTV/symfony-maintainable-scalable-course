<?php

declare(strict_types=1);

namespace App\Controller;

use App\DeprecatedClass;
use Symfony\Component\HttpFoundation\Response;

final class HomeController
{
    public function __construct()
    {
    }

    public function __invoke(): Response
    {
        $deprecatedClass = new DeprecatedClass();
        $deprecatedClass->deprecatedMethod();

        return new Response('<body>ok</body>');
    }
}