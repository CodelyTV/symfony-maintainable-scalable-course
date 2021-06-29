<?php

declare(strict_types=1);

namespace App\Application\find_company;

use App\Domain\CompanyId;
use App\Domain\CompanyRepository;

final class FindCompany
{
    public function __construct(private CompanyRepository $companies)
    {
    }

    public function __invoke(FindCompanyRequest $request): FindCompanyResponse
    {
        $companyId = new CompanyId($request->companyId());
        $company = $this->companies->find($companyId);
        return new FindCompanyResponse($company->id()->value());
    }
}