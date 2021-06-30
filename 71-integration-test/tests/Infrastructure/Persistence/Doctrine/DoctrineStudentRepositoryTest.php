<?php

declare(strict_types=1);

namespace App\Tests\Infrastructure\Persistence\Doctrine;

use App\Domain\Student;
use App\Domain\StudentEmail;
use App\Domain\StudentId;
use App\Domain\StudentPassword;
use App\Infrastructure\Persistence\Doctrine\DoctrineStudentRepository;
use App\Tests\DoctrineTestCase;

final class DoctrineStudentRepositoryTest extends DoctrineTestCase
{
    /** @test */
    public function itShouldSaveAStudent(): void
    {
        /** @var DoctrineStudentRepository $repository */
        $repository = $this->getContainer()->get(DoctrineStudentRepository::class);

        $repository->save($this->makeStudent());
        $this->clearUnitOfWork();
    }


    /** @test */
    public function itShouldFindAStudent(): void
    {
        $student = $this->makeStudent();
        $repository = $this->repositoryWithStudent($student);

        $foundStudent = $repository->find($student->email());

        $this->assertTrue($foundStudent->id()->equalTo($student->id()));
        $this->assertTrue($foundStudent->email()->equalTo($student->email()));
        $this->assertTrue($foundStudent->password()->equalTo($student->password()));
    }

    protected function makeStudent(): Student
    {
        $id = new StudentId('1');
        $email = new StudentEmail('dani@codely.tv');
        $password = new StudentPassword('hashedPassword');
        return new Student($id, $email, $password);
    }

    protected function repositoryWithStudent(Student $student): DoctrineStudentRepository
    {
        /** @var DoctrineStudentRepository $repository */
        $repository = $this->getContainer()->get(DoctrineStudentRepository::class);
        $repository->save($student);
        $this->clearUnitOfWork();
        return $repository;
    }
}