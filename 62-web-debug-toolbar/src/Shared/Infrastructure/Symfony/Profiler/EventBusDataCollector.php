<?php

declare(strict_types=1);

namespace CodelyTv\Shared\Infrastructure\Symfony\Profiler;

use Symfony\Bundle\FrameworkBundle\DataCollector\AbstractDataCollector;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Throwable;

final class EventBusDataCollector extends AbstractDataCollector
{
    /** onKernelResponse */
    public function collect(Request $request, Response $response, Throwable $exception = null)
    {
        $this->data = [
            'domain_events' => $request->attributes->get('_domain_events', []),
            'event_bus' => $request->attributes->get('_event_bus'),
        ];
    }

    public function domainEvents(): array
    {
        return $this->data['domain_events'];
    }

    public function eventBus(): string
    {
        return $this->data['event_bus'];
    }
}