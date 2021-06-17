<?php

declare(strict_types=1);

namespace CodelyTv\Mooc\Users\Application\SendRegistrationEmail;

use CodelyTv\Mooc\Users\Domain\UserRegisteredDomainEvent;
use CodelyTv\Shared\Domain\Bus\Event\DomainEventSubscriber;

final class SendRegistrationEmailOnUserRegistered implements DomainEventSubscriber
{
    public function __construct(private RegistrationEmailSender $emailSender)
    {
    }

    public static function subscribedTo(): array
    {
        return [UserRegisteredDomainEvent::class];
    }

    public function __invoke(UserRegisteredDomainEvent $event): void
    {
        $this->emailSender->send($event->aggregateId());
    }
}