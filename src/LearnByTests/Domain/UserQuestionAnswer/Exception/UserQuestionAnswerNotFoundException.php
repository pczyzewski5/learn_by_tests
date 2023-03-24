<?php

declare(strict_types=1);

namespace LearnByTests\Domain\UserQuestionAnswer\Exception;

use LearnByTests\Domain\Exception\ValidationException;

class UserQuestionAnswerNotFoundException extends ValidationException
{
    public static function notFound(string $id): self
    {
        return new self(
            \sprintf('User answer for question with id: %s not found.', $id)
        );
    }
}
