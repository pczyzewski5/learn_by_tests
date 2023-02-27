<?php

declare(strict_types=1);

namespace LearnByTests\Domain\Exception;

class PersisterException extends DomainException
{
    private function __construct(\Throwable $exception)
    {
        parent::__construct(
            $exception->getMessage(),
            0,
            $exception
        );
    }

    public static function fromThrowable(\Throwable $exception): self
    {
        return new self($exception);
    }
}
