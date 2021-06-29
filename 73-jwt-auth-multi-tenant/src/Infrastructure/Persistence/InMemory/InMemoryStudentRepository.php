<?php

declare(strict_types=1);

namespace App\Infrastructure\Persistence\InMemory;

use App\Domain\CompanyId;
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
            'org1' => [
                'student1@codely.tv' => new Student(
                    new StudentId('student1'),
                    new CompanyId('org1'),
                    new StudentEmail('student1@codely.tv'),
                    new StudentPassword('$argon2id$v=19$m=65536,t=4,p=1$cCMwQS/w3WP4IpK6sAaEEA$en6JXlvwkdyKlEZTTCfr4UZI2GLajda8pIulbXIEdaw') # codely
                )
            ]
        ];
    }

    public function find(CompanyId $companyId, StudentEmail $email): Student
    {
        if (!array_key_exists($companyId->value(), $this->students)) {
            throw new StudentDoesNotExist($email->value());
        }

        $companyStudents = $this->students[$companyId->value()];

        if (!array_key_exists($email->value(), $companyStudents)) {
            throw new StudentDoesNotExist($email->value());
        }

        return $companyStudents[$email->value()];
    }
}