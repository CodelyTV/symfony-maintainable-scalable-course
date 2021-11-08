<?php

declare(strict_types=1);

namespace App\UserInterface;

use Symfony\Component\Security\Core\User\UserInterface;

final class User implements UserInterface
{
    public function getRoles()
    {
    }

    /** @deprecated  */
    public function getPassword()
    {
    }

    /** @deprecated  */
    public function getSalt()
    {
    }

    public function eraseCredentials()
    {
    }

    /** @deprecated  */
    public function getUsername()
    {
    }

    public function getUserIdentifier()
    {
    }
}