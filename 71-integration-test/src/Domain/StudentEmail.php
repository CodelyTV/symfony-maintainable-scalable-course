<?php

declare(strict_types=1);

namespace App\Domain;

final class StudentEmail
{
    public function __construct(private string $studentEmail)
    {
    }

    public function value(): string
    {
        return $this->studentEmail;
    }

    public function __toString(): string
    {
        return $this->studentEmail;
    }

    public function equalTo(StudentEmail $other): bool
    {
        return $this->studentEmail === $other->studentEmail;
    }
}