<?php

declare(strict_types=1);

namespace App\Tests;

use Doctrine\DBAL\Connection;
use Doctrine\ORM\EntityManager;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Test\KernelTestCase;

abstract class DoctrineTestCase extends KernelTestCase
{
    public function entityManager(): EntityManager
    {
        return $this->getContainer()->get(EntityManagerInterface::class);
    }

    public function connection(): Connection
    {
        return $this->getContainer()->get(Connection::class);
    }

    protected function setUp(): void
    {
        $this->clearDatabase();
        // $this->connection()->beginTransaction();
    }

    protected function tearDown(): void
    {
        // $this->connection()->rollBack();
    }

    protected function clearDatabase(): void
    {
        foreach ($this->connection()->getSchemaManager()->listTableNames() as $tableName) {
            $this->connection()->executeQuery('TRUNCATE ' . $tableName);
        }
    }

    protected function clearUnitOfWork(): void
    {
        /** @var EntityManager $entityManager */
        $this->entityManager()->getUnitOfWork()->clear();
    }
}