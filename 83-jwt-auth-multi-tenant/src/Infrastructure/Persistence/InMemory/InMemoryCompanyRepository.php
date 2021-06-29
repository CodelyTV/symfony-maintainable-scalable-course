<?php

declare(strict_types=1);

namespace App\Infrastructure\Persistence\InMemory;

use App\Domain\CompanyId;
use App\Domain\Company;
use App\Domain\CompanyNotExist;
use App\Domain\CompanyRepository;

final class InMemoryCompanyRepository implements CompanyRepository
{
    private array $companies;

    public function __construct()
    {
        $this->companies = [
            'org1' => new Company(new CompanyId('company1'))
        ];
    }

    public function find(CompanyId $companyId): Company
    {
        if (!array_key_exists($companyId->value(), $this->companies)) {
            throw new CompanyNotExist($companyId->value());
        }

        return $this->companies[$companyId->value()];
    }
}