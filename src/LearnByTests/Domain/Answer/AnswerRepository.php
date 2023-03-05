<?php

declare(strict_types=1);

namespace LearnByTests\Domain\Answer;

use LearnByTests\Domain\Answer\Exception\AnswerNotFoundException;

interface AnswerRepository
{
    /**
     * @throws AnswerNotFoundException
     */
    public function getOneById(string $id): Answer;

    /**
     * @return Answer[]
     */
    public function findAll(): array;

    /**
     * @return Answer[]
     */
    public function findForQuestion(string $questionId): array;
}
