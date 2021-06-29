<?php

declare(strict_types=1);

namespace App\Infrastructure\Controller;

use App\Application\find_student\FindStudent;
use App\Application\find_student\FindStudentRequest;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Security\Core\Security;

final class ProfileGetController
{
    public function __construct(private FindStudent $findStudent, private Security $security)
    {
    }

    public function __invoke(): Response
    {
        $symfonyStudent = $this->security->getUser();
        $student = ($this->findStudent)(new FindStudentRequest($symfonyStudent->getUsername()));
        return new JsonResponse($student->studentId());
    }
}