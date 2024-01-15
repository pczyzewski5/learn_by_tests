<?php

declare(strict_types=1);

namespace LearnByTests\Domain\UserQuestionAnswer;

class UserQuestionAnswerFactory
{
    public static function create(
        string $userId,
        string $questionId,
        string $answerId,
    ): UserQuestionAnswer {
        $dto = new UserQuestionAnswerDTO();
        $dto->userId = $userId;
        $dto->questionId = $questionId;
        $dto->answerId = $answerId;
        $dto->createdAt = new \DateTimeImmutable();

        return new UserQuestionAnswer($dto);
    }
}
