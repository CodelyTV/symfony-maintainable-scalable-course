<?php

declare(strict_types=1);

namespace App\Domain;

final class CompanyId
{
    public function __construct(private string $companyId)
    {
    }

    public function value(): string
    {
        return $this->companyId;
    }
}