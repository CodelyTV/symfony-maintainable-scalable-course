<?php

declare(strict_types=1);

namespace App\Infrastructure\Persistence\Doctrine;

use App\Domain\Student;
use App\Domain\StudentEmail;
use App\Domain\StudentRepository;
use Doctrine\ORM\EntityManager;
use Doctrine\ORM\EntityRepository;
use Doctrine\Persistence\ManagerRegistry;

final class DoctrineStudentRepository implements StudentRepository
{
    private EntityManager $entityManager;
    private EntityRepository $repository;

    public function __construct(ManagerRegistry $registry)
    {
        $manager = $registry->getManagerForClass(Student::class);
        $this->entityManager = $manager;
        $this->repository = $manager->getRepository(Student::class);
    }

    public function find(StudentEmail $email): Student
    {
        return $this->repository->findOneBy(['email' => $email]);
    }
}