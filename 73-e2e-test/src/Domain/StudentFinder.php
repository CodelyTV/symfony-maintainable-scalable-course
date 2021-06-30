<?php

declare(strict_types=1);

namespace App\Domain;

final class StudentFinder
{
    public function __construct(private StudentRepository $students)
    {
    }

    public function find(StudentEmail $email): Student
    {
        return $this->students->find($email);
    }
}