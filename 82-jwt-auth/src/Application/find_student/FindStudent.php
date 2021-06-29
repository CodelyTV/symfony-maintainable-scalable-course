<?php

declare(strict_types=1);

namespace App\Application\find_student;

use App\Domain\StudentEmail;
use App\Domain\StudentFinder;

final class FindStudent
{
    public function __construct(private StudentFinder $studentFinder)
    {
    }

    public function __invoke(FindStudentRequest $request): FindStudentResponse
    {
        $email = new StudentEmail($request->studentEmail());
        $student = $this->studentFinder->find($email);
        return new FindStudentResponse(
            $student->id()->value(),
            $student->email()->value(),
            $student->password()->value()
        );
    }
}