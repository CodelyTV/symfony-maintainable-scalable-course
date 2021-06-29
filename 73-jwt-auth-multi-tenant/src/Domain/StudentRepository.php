<?php

declare(strict_types=1);

namespace App\Domain;

interface StudentRepository
{
    /** @throws StudentDoesNotExist */
    public function find(CompanyId $companyId, StudentEmail $email): Student;
}