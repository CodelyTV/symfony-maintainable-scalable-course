<?php

declare(strict_types=1);

namespace CodelyTv\Mooc\Users\Application\Register;

use CodelyTv\Shared\Domain\Bus\Command\Command;

final class RegisterUserCommand implements Command
{
    public function __construct(private string $id, private string $email)
    {
    }

    public function id(): string
    {
        return $this->id;
    }

    public function email(): string
    {
        return $this->email;
    }
}