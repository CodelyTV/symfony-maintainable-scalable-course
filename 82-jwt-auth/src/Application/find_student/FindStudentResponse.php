<?php

declare(strict_types=1);

namespace App\Application\find_student;

final class FindStudentResponse
{
    public function __construct(
        private string $studentId,
        private string $studentEmail,
        private string $studentPassword
    ) {
    }

    public function studentId(): string
    {
        return $this->studentId;
    }

    public function studentEmail(): string
    {
        return $this->studentEmail;
    }

    public function studentPassword(): string
    {
        return $this->studentPassword;
    }
}