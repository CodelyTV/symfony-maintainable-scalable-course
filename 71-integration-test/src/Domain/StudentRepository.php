<?php

declare(strict_types=1);

namespace App\Domain;

interface StudentRepository
{
    /** @throws StudentDoesNotExist */
    public function find(StudentEmail $email): Student;

    public function save(Student $student): void;
}