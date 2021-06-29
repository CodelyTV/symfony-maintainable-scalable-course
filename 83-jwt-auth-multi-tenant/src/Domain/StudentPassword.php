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
}