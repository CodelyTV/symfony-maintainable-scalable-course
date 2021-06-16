<?php

declare(strict_types=1);

namespace CodelyTv\Mooc\Users\Domain;

interface UserRepository
{
    public function save(User $user): void;
}