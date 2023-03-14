<?php

namespace App;

use MyCLabs\Enum\Enum;

abstract class BaseEnum extends Enum
{
    public static function toFlippedArray(): array
    {
        return \array_flip(self::toArray());
    }

    public static function arrayValues(): array
    {
        return \array_values(self::toArray());
    }

    public static function fromKey($string): self
    {
        return self::$string();
    }
}