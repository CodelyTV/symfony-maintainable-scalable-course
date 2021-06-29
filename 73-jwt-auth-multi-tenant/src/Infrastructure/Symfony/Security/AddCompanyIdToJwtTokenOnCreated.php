<?php

declare(strict_types=1);

namespace App\Infrastructure\Symfony\Security;

use Lexik\Bundle\JWTAuthenticationBundle\Event\JWTCreatedEvent;
use Lexik\Bundle\JWTAuthenticationBundle\Events;
use Symfony\Component\EventDispatcher\EventSubscriberInterface;
use Symfony\Component\HttpFoundation\RequestStack;

final class AddCompanyIdToJwtTokenOnCreated implements EventSubscriberInterface
{
    public function __construct(
        private RequestStack $requestStack,
        private string $tenantArgumentName
    ) {
    }

    public static function getSubscribedEvents(): array
    {
        return [Events::JWT_CREATED => 'onJWTCreated'];
    }

    public function onJWTCreated(JWTCreatedEvent $event)
    {
        $payload = $event->getData();
        $request = $this->requestStack->getMainRequest();
        $payload['tenant_id'] = $request->attributes->get($this->tenantArgumentName);
        $event->setData($payload);
    }
}