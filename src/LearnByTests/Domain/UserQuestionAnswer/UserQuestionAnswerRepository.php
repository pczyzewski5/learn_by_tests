<?php

declare(strict_types=1);

namespace LearnByTests\Domain\UserQuestionAnswer;

use LearnByTests\Domain\UserQuestionAnswer\Exception\UserQuestionAnswerNotFoundException;
use LearnByTests\Domain\UserQuestionAnswer\UserQuestionAnswer;

interface UserQuestionAnswerRepository
{
    /**
     * @throws UserQuestionAnswerNotFoundException
     */
    public function findOne(string $userId, string $questionId): ?UserQuestionAnswer;
}
