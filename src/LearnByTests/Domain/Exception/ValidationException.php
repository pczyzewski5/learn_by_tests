<?php

declare(strict_types=1);

namespace LearnByTests\Domain\Exception;

class ValidationException extends DomainException
{
    public static function missingProperty($propertyName): self
    {
        return new self(
            \sprintf('%s must be set.', $propertyName)
        );
    }
}
