<?php

declare(strict_types=1);

namespace App\Infrastructure\Symfony\Security;

use Lexik\Bundle\JWTAuthenticationBundle\Security\User\JWTUserInterface;
use Symfony\Component\Security\Core\User\PasswordAuthenticatedUserInterface;

final class JwtUser implements JWTUserInterface, PasswordAuthenticatedUserInterface
{
    public function __construct(
        private string $userId,
        private string $companyId,
        private string $email,
        private string $hashedPassword
    )
    {
    }

    public function userId(): string
    {
        return $this->userId;
    }

    public function companyId(): string
    {
        return $this->companyId;
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

    public static function createFromPayload($username, array $payload): JwtUser
    {
        return new self($payload['id'], $username, '', $payload['tenant_id']);
    }
}