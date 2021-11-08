<?php

declare(strict_types=1);

namespace App\Mercure\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;

final class SubscribeController extends AbstractController
{
    public function __invoke(): Response
    {
        return $this->render('subscribe.html.twig');
    }
}