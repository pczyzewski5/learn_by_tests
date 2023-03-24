<?php

declare(strict_types=1);

namespace LearnByTests\Domain\UserQuestionAnswer;

use LearnByTests\Domain\UserQuestionAnswer\Exception\UserQuestionAnswerNotFoundException;

interface UserQuestionAnswerRepository
{
    /**
     * @throws UserQuestionAnswerNotFoundException
     */
    public function getOneById(string $id): UserQuestionAnswer;

    /**
     * @return UserQuestionAnswer[]
     */
    public function findAll(): array;
}
