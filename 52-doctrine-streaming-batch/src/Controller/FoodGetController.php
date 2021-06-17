<?php

declare(strict_types=1);

namespace App\Controller;

use App\Entity\Food;
use Doctrine\DBAL\Connection;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Component\HttpFoundation\BinaryFileResponse;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\HttpFoundation\StreamedResponse;

final class FoodGetController
{
    const FOOD_CSV_FILE = __DIR__ . '/../../var/branded_food.csv';
    const SEARCH_TERM = 'soy';

    public function __construct(
        private EntityManagerInterface $entityManager,
        private Connection $connection
    )
    {
    }

    public function fileGetContents(): Response
    {
        $data = file_get_contents(self::FOOD_CSV_FILE);
        $result = '';
        foreach(explode(PHP_EOL, $data) as $line) {
            if (strpos($line, self::SEARCH_TERM) !== false) {
                $result .= $line;
            }
        }
        return new Response($result);
    }

    public function fopen(): Response
    {
        $fileHandle = fopen(self::FOOD_CSV_FILE, 'r');
        if (!$fileHandle) {
            return new Response('File not found', 404);
        }

        $result = '';
        while (!feof($fileHandle)) {
            $line = fgets($fileHandle);
            if (!$line) {
                break;
            }
            if (strpos($line, self::SEARCH_TERM) !== false) {
                $result .= $line;
            }
        }

        fclose($fileHandle);

        return new Response($result);
    }

    public function streamed(): Response
    {
        $fileHandle = fopen(self::FOOD_CSV_FILE, 'r');
        if (!$fileHandle) {
            return new Response('File not found', 404);
        }

        $response = new StreamedResponse();
        $response->setCallback(function () use ($fileHandle) {
            while (!feof($fileHandle)) {
                $line = fgets($fileHandle);
                if (!$line) {
                    break;
                }
                if (strpos($line, self::SEARCH_TERM) !== false) {
                    echo $line;
                }
            }

            fclose($fileHandle);
        });
        $response->headers->set('Content-Type', 'text/plain');
        return $response;
    }

    public function streamedLogging(): Response
    {
        $fileHandle = fopen(self::FOOD_CSV_FILE, 'r');
        if (!$fileHandle) {
            return new Response('File not found', 404);
        }

        $response = new StreamedResponse();
        $response->setCallback(function () use ($fileHandle) {
            $lineCount = 0;
            echo '<script>console.log("starting")</script>';
            while (!feof($fileHandle)) {
                $line = fgets($fileHandle);
                if (!$line) {
                    break;
                }
                $lineCount++;
                if (strpos($line, self::SEARCH_TERM) !== false) {
                    echo $line;
                }

                if ($lineCount % 1000 === 0) {
                    echo '<script>console.log("' . $lineCount . '")</script>';
                }
            }

            fclose($fileHandle);
        });
        return $response;
    }

    public function binary(): Response
    {
        return new BinaryFileResponse(self::FOOD_CSV_FILE);
    }

    public function streamedDoctrine(): Response
    {
        $response = new StreamedResponse();
        $response->setCallback(function() {
            $query = $this->entityManager->createQuery("SELECT f FROM App\Entity\Food f ORDER BY f.id DESC");
            /** @var Food $food */
            foreach ($query->toIterable() as $key => $food) {
                echo $food->id() . ' ' . $food->name() . PHP_EOL;

                $this->entityManager->clear($food);
            }
        });
        $response->headers->set('Content-Type', 'text/plain');
        return $response;
    }

    // http://localhost:8000/dbal/CAMPBELL SOUP COMPANY
    // http://localhost:8000/dbal/'%20OR%20'1'='1
    /**
     * @throws \Doctrine\DBAL\Driver\Exception
     * @throws \Doctrine\DBAL\Exception
     */
    public function dbalSQLi(string $name): Response
    {
        $result = $this->connection->executeQuery("SELECT * FROM food f WHERE f.name = '$name' ORDER BY f.id DESC");
        return new JsonResponse($result->fetchAllAssociative());
    }

    // http://localhost:8000/dbal/'%20OR%20'1'='1
    // http://localhost:8000/dbal/CAMPBELL SOUP COMPANY
    /**
     * @throws \Doctrine\DBAL\Driver\Exception
     * @throws \Doctrine\DBAL\Exception
     */
    public function dbal(string $name): Response
    {
        $sql = "SELECT * FROM food WHERE name = :name";
        $stmt = $this->connection->prepare($sql);
        $stmt->bindValue("name", $name);
        $result = $stmt->executeQuery();
        return new JsonResponse($result->fetchAllAssociative());
    }

    // http://localhost:8000/dbal/CAMPBELL SOUP COMPANY
    // http://localhost:8000/dbal/'%20OR%20'1'='1
    /**
     * @throws \Doctrine\DBAL\Driver\Exception
     * @throws \Doctrine\DBAL\Exception
     */
    public function queryBuilder(string $name): Response
    {
        $result = $this->connection->createQueryBuilder()
            ->select('id', 'name')
            ->from('food')
            ->where('name = :name')
            ->setParameter('name', $name)
            ->execute()
        ;
        return new JsonResponse($result->fetchAllAssociative());
    }

    // http://localhost:8000/dbal/CAMPBELL SOUP COMPANY
    // http://localhost:8000/dbal/'%20OR%20'1'='1
    /**
     * @throws \Doctrine\DBAL\Driver\Exception
     * @throws \Doctrine\DBAL\Exception
     */
    public function orm(string $name): Response
    {
        $query = $this->entityManager->createQuery(
            "SELECT f FROM App\Entity\Food f WHERE f.name = :name ORDER BY f.id DESC"
        );
        $results = $query->execute(['name' => $name ]);

        return new JsonResponse(
            array_map(function(Food $food) {
                return [
                    'id' => $food->id(),
                    'name' => $food->name()
                ];
            }, $results)
        );
    }
}