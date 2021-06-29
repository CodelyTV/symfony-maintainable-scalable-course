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
}