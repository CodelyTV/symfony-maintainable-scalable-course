<?php

declare(strict_types=1);

namespace App\Domain;

final class StudentId
{
    public function __construct(private string $studentId)
    {
    }

    public function value(): string
    {
        return $this->studentId;
    }
}