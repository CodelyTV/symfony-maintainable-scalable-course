<?php

declare(strict_types=1);

namespace App\Infrastructure\Persistence\Doctrine\Type;

use App\Domain\StudentPassword;
use Doctrine\DBAL\Platforms\AbstractPlatform;
use Doctrine\DBAL\Types\StringType;

final class StudentPasswordType extends StringType
{
    public function convertToDatabaseValue($value, AbstractPlatform $platform): string
    {
        return $value->value();
    }

    public function convertToPHPValue($value, AbstractPlatform $platform): StudentPassword
    {
        return new StudentPassword($value);
    }
}