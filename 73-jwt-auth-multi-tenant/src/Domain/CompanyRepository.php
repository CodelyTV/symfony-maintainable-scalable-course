<?php

declare(strict_types=1);

namespace App\Domain;

interface CompanyRepository
{
    /** @throws CompanyNotExist */
    public function find(CompanyId $companyId): Company;
}