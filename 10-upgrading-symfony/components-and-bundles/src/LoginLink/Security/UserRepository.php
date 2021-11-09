<?php

declare(strict_types=1);

namespace App\LoginLink\Security;

use RuntimeException;
use Symfony\Component\Security\Core\Exception\UserNotFoundException;

final class UserRepository
{
    private array $users;

    public function __construct()
    {
        $this->users['user@codely.tv'] = new User('user@codely.tv');
    }

    public function find(string $email): User
    {
        if (!array_key_exists($email, $this->users)) {
            throw new UserNotFoundException('User not found!');
        }

        return $this->users[$email];
    }
}