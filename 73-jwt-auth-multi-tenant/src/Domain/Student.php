<?php

declare(strict_types=1);

namespace App\Domain;

final class Student
{
    public function __construct(
        private StudentId $id,
        private StudentEmail $email,
        private StudentPassword  $password
    ) {
    }

    public function id(): StudentId
    {
        return $this->id;
    }

    public function email(): StudentEmail
    {
        return $this->email;
    }

    public function password(): StudentPassword
    {
        return $this->password;
    }
}