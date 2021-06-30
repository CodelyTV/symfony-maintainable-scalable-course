<?php

declare(strict_types=1);

namespace App\Domain;

final class StudentPassword
{
    public function __construct(private string $studentPassword)
    {
    }

    public function value(): string
    {
        return $this->studentPassword;
    }

    public function __toString(): string
    {
        return $this->studentPassword;
    }

    public function equalTo(StudentPassword $other): bool
    {
        return $this->studentPassword === $other->studentPassword;
    }
}