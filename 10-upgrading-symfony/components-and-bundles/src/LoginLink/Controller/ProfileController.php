<?php

declare(strict_types=1);

namespace App\LoginLink\Controller;

use Symfony\Component\HttpFoundation\Response;

final class ProfileController
{
    public function __invoke(): Response
    {
        return new Response('<body>profile</body>');
    }
}