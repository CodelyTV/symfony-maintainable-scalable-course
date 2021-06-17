<?php

declare(strict_types=1);

namespace App\Repository;

interface FoodRepository
{
    public function all(): iterable;

    public function saveAll(iterable $foods): void;
}