<?php

declare(strict_types=1);

namespace LearnByTests\Domain\Answer\Exception;

use LearnByTests\Domain\Exception\ValidationException;

class AnswerNotFoundException extends ValidationException
{
    public static function notFound(string $id): self
    {
        return new self(
            \sprintf('Answer with id: %s not found.', $id)
        );
    }
}
