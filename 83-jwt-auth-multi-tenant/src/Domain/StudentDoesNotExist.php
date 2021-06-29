<?php

declare(strict_types=1);

namespace App\Domain;

use RuntimeException;

final class StudentDoesNotExist extends RuntimeException
{
    public function __construct(string $studentEmail)
    {
        parent::__construct("Student with email '$studentEmail' does not exist");
    }
}