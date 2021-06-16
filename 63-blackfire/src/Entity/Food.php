<?php

declare(strict_types=1);

namespace App\Entity;

class Food
{
    public function __construct(
        private $id,
        private $name
    )
    {
    }

    public function id()
    {
        return $this->id;
    }

    public function name()
    {
        return $this->name;
    }

    public function setName($name): void
    {
        $this->name = $name;
    }

    public function hasBannedWords(array $bannedWords): bool
    {
        foreach ($bannedWords as $word) {
            if (str_contains($this->name(), $word)) {
                return true;
            }
        }

        return false;
    }
}