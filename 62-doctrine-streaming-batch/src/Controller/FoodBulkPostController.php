<?php

declare(strict_types=1);

namespace App\Controller;

use App\Entity\Food;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Component\HttpFoundation\Response;

final class FoodBulkPostController
{
    const FOOD_CSV_FILE = __DIR__ . '/../../var/branded_food.csv';

    public function __construct(
        private EntityManagerInterface $entityManager
    )
    {
    }

    public function noBatch()
    {
        $fileHandle = fopen(self::FOOD_CSV_FILE, 'r');
        if (!$fileHandle) {
            return new Response('File not found', 404);
        }

        while (!feof($fileHandle)) {
            $line = fgetcsv($fileHandle);
            if (!$line) {
                break;
            }

            $food = new Food($line[0], $line[1]);

            $this->entityManager->persist($food);
        }

        $this->entityManager->flush();
        $this->entityManager->clear();

        fclose($fileHandle);

        return new Response();
    }

    public function batch(): Response
    {
        $fileHandle = fopen(self::FOOD_CSV_FILE, 'r');
        if (!$fileHandle) {
            return new Response('File not found', 404);
        }

        $batchSize = 50;
        $total = 0;

        while (!feof($fileHandle)) {
            $line = fgetcsv($fileHandle);
            if (!$line) {
                break;
            }

            $food = new Food($line[0], $line[1]);

            $this->entityManager->persist($food);
            if (($total % $batchSize) === 0) {
                $this->entityManager->flush();
                $this->entityManager->clear();
            }
            $total++;

            if ($total === 30000) {
                break;
            }
        }
        $this->entityManager->flush();
        $this->entityManager->clear();

        fclose($fileHandle);

        return new Response();
    }
}