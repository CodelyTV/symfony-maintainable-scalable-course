<?php

declare(strict_types=1);

namespace CodelyTv\Mooc\Users\Domain;

use CodelyTv\Shared\Domain\Bus\Event\DomainEvent;

final class UserRegisteredDomainEvent extends DomainEvent
{
    public function __construct(
        string $id,
        private string $email,
        string $eventId = null,
        string $occurredOn = null
    ) {
        parent::__construct($id, $eventId, $occurredOn);
    }

    public static function eventName(): string
    {
        return 'user.registered';
    }

    public static function fromPrimitives(
        string $aggregateId,
        array $body,
        string $eventId,
        string $occurredOn): DomainEvent {
        return new self($aggregateId, $body['email'], $eventId, $occurredOn);
    }

    public function toPrimitives(): array
    {
        return [
            'email'     => $this->email,
        ];
    }

    public function email(): string
    {
        return $this->email;
    }
}