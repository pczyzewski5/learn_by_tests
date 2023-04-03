<?php

declare(strict_types=1);

namespace LearnByTests\Domain\UserSkippedQuestion\Exception;

use LearnByTests\Domain\Exception\ValidationException;

class UserSkippedQuestionNotFoundException extends ValidationException
{
    public static function notFound(string $id): self
    {
        return new self(
            \sprintf('User skipped question with id: %s not found.', $id)
        );
    }
}
