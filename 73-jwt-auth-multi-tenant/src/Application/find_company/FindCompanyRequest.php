<?php

declare(strict_types=1);

namespace App\Application\find_company;

final class FindCompanyRequest
{
    public function __construct(private string $companyId)
    {
    }

    public function companyId(): string
    {
        return $this->companyId;
    }
}