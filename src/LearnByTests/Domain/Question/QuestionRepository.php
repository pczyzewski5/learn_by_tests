<?php

declare(strict_types=1);

namespace LearnByTests\Domain\Question;

use LearnByTests\Domain\Answer\Exception\AnswerNotFoundException;

interface QuestionRepository
{
    /**
     * @throws AnswerNotFoundException
     */
    public function getOneById(string $id): Question;

    /**
     * @return Question[]
     */
    public function findAll(): array;

    /**
     * @return Question[]
     */
    public function findAllByCategory(string $category): array;

    /**
     * @return Question[]
     */
    public function findAllBySubcategory(string $subcategory): array;
}
