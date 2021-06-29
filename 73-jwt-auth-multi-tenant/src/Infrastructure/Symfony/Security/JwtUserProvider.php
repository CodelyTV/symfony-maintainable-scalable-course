<?php

declare(strict_types=1);

namespace App\Infrastructure\Symfony\Security;

use App\Application\find_student\FindStudent;
use App\Application\find_student\FindStudentRequest;
use App\Domain\StudentDoesNotExist;
use Symfony\Component\Security\Core\Exception\UserNotFoundException;
use Symfony\Component\Security\Core\User\UserInterface;
use Symfony\Component\Security\Core\User\UserProviderInterface;

final class JwtUserProvider implements UserProviderInterface
{
    public function __construct(private FindStudent $findStudent) {
    }

    public function loadUserByIdentifier(string $identifier): JwtUser
    {
        return $this->loadUser($identifier);
    }

    public function loadUserByUsername(string $username): JwtUser
    {
        return $this->loadUserByIdentifier($username);
    }

    public function refreshUser(UserInterface $user): UserInterface
    {
        return $user;
    }

    public function supportsClass(string $class): bool
    {
        return $class === JwtUser::class;
    }

    public function loadUser(string $identifier): JwtUser
    {
        try {
            $student = ($this->findStudent)(new FindStudentRequest($identifier));
            return new JwtUser(
                $student->studentId(),
                $student->studentEmail(),
                $student->studentPassword()
            );
        } catch (StudentDoesNotExist $exception) {
            throw new UserNotFoundException($identifier);
        }
    }
}