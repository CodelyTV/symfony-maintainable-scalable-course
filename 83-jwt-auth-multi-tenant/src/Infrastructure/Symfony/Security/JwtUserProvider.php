<?php

declare(strict_types=1);

namespace App\Infrastructure\Symfony\Security;

use App\Application\find_student\FindStudent;
use App\Application\find_student\FindStudentRequest;
use App\Domain\StudentDoesNotExist;
use Lexik\Bundle\JWTAuthenticationBundle\Security\User\PayloadAwareUserProviderInterface;
use Symfony\Component\HttpFoundation\RequestStack;
use Symfony\Component\Security\Core\Exception\UserNotFoundException;
use Symfony\Component\Security\Core\User\UserInterface;

final class JwtUserProvider implements PayloadAwareUserProviderInterface
{
    public function __construct(
        private FindStudent $findStudent,
        private RequestStack $requestStack,
        private string $tenantArgumentName
    ) {
    }

    public function loadUserByIdentifierAndPayload(string $identifier, array $payload): JwtUser
    {
        return $this->loadUser($payload['tenant_id'], $identifier);
    }

    public function loadUserByUsernameAndPayload(string $username, array $payload): JwtUser
    {
        return $this->loadUserByIdentifierAndPayload($username, $payload);
    }

    public function loadUserByIdentifier(string $email): JwtUser
    {
        $request = $this->requestStack->getMainRequest();
        $companyId = $request->attributes->get($this->tenantArgumentName);

        return $this->loadUser($companyId, $email);
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

    public function loadUser(string $companyId, string $email): JwtUser
    {
        try {
            $student = ($this->findStudent)(new FindStudentRequest($companyId, $email));
            return new JwtUser(
                $student->studentId(),
                $student->companyId(),
                $student->studentEmail(),
                $student->studentPassword()
            );
        } catch (StudentDoesNotExist $exception) {
            throw new UserNotFoundException($email);
        }
    }
}