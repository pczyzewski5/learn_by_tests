<?php

declare(strict_types=1);

namespace LearnByTests\Domain\Question\Exception;

use LearnByTests\Domain\Exception\ValidationException;

class QuestionNotFoundException extends ValidationException
{
    public static function notFound(string $id): self
    {
        return new self(
            \sprintf('Question with id: %s not found.', $id)
        );
    }
}
