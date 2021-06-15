<?php

declare(strict_types=1);

namespace CodelyTv\Apps\Mooc\Backend\Controller\HealthCheck;

use CodelyTv\Mooc\Courses\Domain\CourseCreatedDomainEvent;
use CodelyTv\Mooc\CoursesCounter\Domain\CoursesCounterIncrementedDomainEvent;
use CodelyTv\Shared\Domain\Bus\Event\EventBus;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;

final class PublishDomainEventsGetController
{
    public function __construct(private EventBus $eventBus)
    {
    }

    public function __invoke(Request $request): Response
    {
        $this->eventBus->publish(
            new CourseCreatedDomainEvent(
                '620b6110-2766-46f4-9a40-279d577befbe',
                'Arquitectura Hexagonal',
                '3'
            ),
            new CoursesCounterIncrementedDomainEvent(
                '66fce5bb-0f47-4afe-97ab-fe3e22d22637',
                5
            )
        );

        return new Response('<body>2 events published</body>');
    }
}
