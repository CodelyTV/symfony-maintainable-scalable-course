<?php

declare(strict_types=1);

namespace App\Mercure\Controller;

use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Mercure\HubInterface;
use Symfony\Component\Mercure\Update;
use Symfony\Component\Uid\Uuid;

final class PublishController
{
    public function __construct(private HubInterface $hub)
    {
    }

    public function __invoke(): Response
    {
        $update = new Update(
            'https://example.com/courses/1',
            json_encode([
                'event' => 'CoursePublished',
                'eventId' => UUid::v4()
            ])
        );

        $this->hub->publish($update);

        return new Response('published!');
    }
}