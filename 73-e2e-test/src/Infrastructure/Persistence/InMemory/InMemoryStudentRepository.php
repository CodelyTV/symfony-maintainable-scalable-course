<?php

declare(strict_types=1);

namespace App\Infrastructure\Persistence\InMemory;

use App\Domain\Student;
use App\Domain\StudentEmail;
use App\Domain\StudentId;
use App\Domain\StudentDoesNotExist;
use App\Domain\StudentPassword;
use App\Domain\StudentRepository;

final class InMemoryStudentRepository implements StudentRepository
{
    private array $students;

    public function __construct()
    {
        $this->students = [
            'student1@codely.tv' => new Student(
                new StudentId('student1'),
                new StudentEmail('student1@codely.tv'),
                new StudentPassword('$argon2id$v=19$m=65536,t=4,p=1$cCMwQS/w3WP4IpK6sAaEEA$en6JXlvwkdyKlEZTTCfr4UZI2GLajda8pIulbXIEdaw') # codely
            )
        ];
    }

    public function find(StudentEmail $email): Student
    {
        if (!array_key_exists($email->value(), $this->students)) {
            throw new StudentDoesNotExist($email->value());
        }

        return $this->students[$email->value()];
    }
}