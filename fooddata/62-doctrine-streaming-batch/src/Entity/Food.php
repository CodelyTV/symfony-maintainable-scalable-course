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
}