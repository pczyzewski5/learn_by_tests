<?php

declare(strict_types=1);

namespace LearnByTests\Domain\UserSkippedQuestion;

class UserSkippedQuestionFactory
{
    public static function create(
        string $userId,
        string $questionId,
    ): UserSkippedQuestion {
        $dto = new UserSkippedQuestionDTO();
        $dto->userId = $userId;
        $dto->questionId = $questionId;
        $dto->createdAt = new \DateTimeImmutable();

        return new UserSkippedQuestion($dto);
    }
}
