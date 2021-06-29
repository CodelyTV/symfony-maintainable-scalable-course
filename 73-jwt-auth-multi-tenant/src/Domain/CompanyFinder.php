<?php

declare(strict_types=1);

namespace App\Domain;

final class CompanyFinder
{
    public function __construct(private CompanyRepository $companies)
    {
    }

    public function find(CompanyId $companyId): Company
    {
        return $this->companies->find($companyId);
    }
}