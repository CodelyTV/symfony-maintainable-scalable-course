<?php

declare(strict_types=1);

namespace App\Controller;

use App\Entity\Food;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Component\HttpFoundation\BinaryFileResponse;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\HttpFoundation\StreamedResponse;

final class FoodGetController
{
    const FOOD_CSV_FILE = __DIR__ . '/../../var/branded_food.csv';
    const SEARCH_TERM = '';

    public function __construct(
        private EntityManagerInterface $entityManager
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

        return new StreamedResponse(function() use ($fileHandle) {
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
    }

    public function streamedLogging(): Response
    {
        $fileHandle = fopen(self::FOOD_CSV_FILE, 'r');
        if (!$fileHandle) {
            return new Response('File not found', 404);
        }

        return new StreamedResponse(function() use ($fileHandle) {
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
                    echo '<script>console.log("'.$lineCount.'")</script>';
                }
            }

            fclose($fileHandle);
        });
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
            foreach ($query->toIterable() as $food) {
                echo $food->id() . ' ' . $food->name() . PHP_EOL;

                $this->entityManager->detach($food);
            }
        });
        $response->headers->set('Content-Type', 'text/plain');
        return $response;
    }
}