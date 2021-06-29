<?php

declare(strict_types=1);

namespace App\Infrastructure\Persistence\Doctrine\Type;

use App\Domain\StudentId;
use Doctrine\DBAL\Platforms\AbstractPlatform;
use Doctrine\DBAL\Types\StringType;

final class StudentIdType extends StringType
{
    /** @param StudentId $value */
    public function convertToDatabaseValue($value, AbstractPlatform $platform): string
    {
        return $value->value();
    }

    public function convertToPHPValue($value, AbstractPlatform $platform): StudentId
    {
        return new StudentId($value);
    }
}