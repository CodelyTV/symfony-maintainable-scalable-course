<?php

declare(strict_types=1);

namespace App\NativeTypes;

use Symfony\Component\Security\Core\User\UserInterface;

final class User implements UserInterface
{
    public function getRoles()
    {
    }

    public function getPassword()
    {
    }

    public function getSalt()
    {
    }

    public function eraseCredentials()
    {
    }

    public function getUsername()
    {
    }

    public function getUserIdentifier()
    {
    }
}