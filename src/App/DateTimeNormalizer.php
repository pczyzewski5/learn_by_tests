<?php

declare(strict_types=1);

namespace App;

use DateTimeImmutable;
use DateTimeInterface;

class DateTimeNormalizer
{
    public static function normalizeToImmutable(DateTimeInterface $dateTime): DateTimeImmutable
    {
        return $dateTime instanceof DateTimeImmutable
            ? $dateTime
            : DateTimeImmutable::createFromMutable($dateTime);
    }
}
