<?php

declare(strict_types=1);

namespace App\Infrastructure\Symfony\Security;

use Symfony\Component\Security\Core\User\PasswordAuthenticatedUserInterface;
use Symfony\Component\Security\Core\User\UserInterface;

final class JwtUser implements UserInterface, PasswordAuthenticatedUserInterface
{
    public function __construct(
        private string $userId,
        private string $email,
        private string $hashedPassword
    ) {
    }

    public function userId(): string
    {
        return $this->userId;
    }

    public function getRoles(): array
    {
        return [];
    }

    public function getPassword(): string
    {
        return $this->hashedPassword;
    }

    public function getSalt(): ?string
    {
        return null;
    }

    public function getUserIdentifier(): string
    {
        return $this->email;
    }
    
    public function getUsername(): string
    {
        return $this->getUserIdentifier();
    }

    public function eraseCredentials(): void
    {
    }
}