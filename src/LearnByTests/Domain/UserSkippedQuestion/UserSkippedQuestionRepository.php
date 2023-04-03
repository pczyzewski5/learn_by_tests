<?php

declare(strict_types=1);

namespace LearnByTests\Domain\UserSkippedQuestion;

use LearnByTests\Domain\UserQuestionAnswer\Exception\UserQuestionAnswerNotFoundException;

interface UserSkippedQuestionRepository
{
    /**
     * @throws UserQuestionAnswerNotFoundException
     */
    public function findOne(string $userId, string $questionId): ?UserSkippedQuestion;

    /**
     * @return string[]
     */
    public function findAllQuestionIds(string $userId): array;

    public function isSkipped(string $userId, string $questionId): bool;
}
