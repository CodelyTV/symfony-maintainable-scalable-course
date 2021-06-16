<?php

declare(strict_types=1);

namespace App\Infrastructure\Feed;

use App\Entity\Food;
use http\Exception\RuntimeException;

final class LocalFileFeedFetcher
{
    public function fetch(string $file): iterable
    {
        $fileHandle = fopen($file, 'r');
        if (!$fileHandle) {
            throw new RuntimeException('File not found');
        }

        $total = 0;
        while (!feof($fileHandle)) {
            $csvLine = fgetcsv($fileHandle);
            if (!$csvLine || $total === 50000) {
                break;
            }

            yield $this->parseProduct($csvLine);
            $total++;
        }

        fclose($fileHandle);
    }

    private function parseProduct(array $csvLine): Food
    {
        return new Food($csvLine[0], $csvLine[1]);
    }
}