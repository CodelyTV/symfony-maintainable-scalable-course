<?php

declare(strict_types=1);

namespace App\Repository;

use App\Entity\Food;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Persistence\ManagerRegistry;

final class DoctrineFoodRepository extends ServiceEntityRepository implements FoodRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, Food::class);
    }

    /** @return iterable<Food> */
    public function all(): iterable
    {
        $query = $this->_em->createQuery("SELECT f FROM App\Entity\Food f ORDER BY f.id DESC");
        /** @var Food $food */
        foreach ($query->toIterable() as $food) {
            yield $food;
        }
    }

    public function saveAll(iterable $foods): void
    {
        $batchSize = 50;
        $total = 0;

        foreach ($foods as $food) {
            $this->_em->persist($food);
            if (($total % $batchSize) === 0) {
                $this->_em->flush();
                $this->_em->clear();
            }
            $total++;
        }

        $this->_em->flush();
        $this->_em->clear();
    }
}