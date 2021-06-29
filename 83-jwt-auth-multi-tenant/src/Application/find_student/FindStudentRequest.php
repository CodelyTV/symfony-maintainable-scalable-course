<?php

declare(strict_types=1);

namespace App\Application\find_student;

final class FindStudentRequest
{
    public function __construct(private string $companyId, private string $studentEmail)
    {
    }

    public function companyId(): string
    {
        return $this->companyId;
    }

    public function studentEmail(): string
    {
        return $this->studentEmail;
    }
}