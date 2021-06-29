<?php

declare(strict_types=1);

namespace App\Domain;

final class Company
{
    public function __construct(private CompanyId $id)
    {
    }

    public function id(): CompanyId
    {
        return $this->id;
    }
}