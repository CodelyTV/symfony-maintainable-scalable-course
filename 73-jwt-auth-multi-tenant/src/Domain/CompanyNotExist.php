<?php

declare(strict_types=1);

namespace App\Domain;

use RuntimeException;

final class CompanyNotExist extends RuntimeException
{
    public function __construct(string $companyId)
    {
        parent::__construct("Company with id '$companyId' does not exist");
    }
}