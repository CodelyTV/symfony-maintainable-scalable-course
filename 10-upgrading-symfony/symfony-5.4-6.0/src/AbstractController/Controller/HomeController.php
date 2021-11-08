<?php

declare(strict_types=1);

namespace App\AbstractController\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;

final class HomeController extends AbstractController
{
    public function __invoke(): Response
    {
        $this->get('router');
        $this->has('router');
        $this->getDoctrine();
        $this->dispatchMessage(new \stdClass());
        return new Response('<body>ok</body>');
    }
}