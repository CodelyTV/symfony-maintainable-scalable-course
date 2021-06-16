<?php

declare(strict_types=1);

namespace CodelyTv\Mooc\Users\Domain;

use CodelyTv\Shared\Domain\Aggregate\AggregateRoot;

final class User extends AggregateRoot
{
    public function __construct(private UserId $id, private UserEmail $email)
    {
    }

    public static function register(UserId $id, UserEmail $email): self
    {
        $user = new self($id, $email);

        $user->record(new UserRegisteredDomainEvent($id->value(), $email->value()));

        return $user;
    }

    public function id(): UserId
    {
        return $this->id;
    }

    public function email(): UserEmail
    {
        return $this->email;
    }
}