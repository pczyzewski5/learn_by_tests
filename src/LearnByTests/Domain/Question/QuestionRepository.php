<?php

declare(strict_types=1);

namespace LearnByTests\Domain\Question;

use LearnByTests\Domain\Answer\Exception\AnswerNotFoundException;
use LearnByTests\Domain\Category\CategoryEnum;

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
    public function findAllByCategory(
        string $category,
        ?int $limit = null,
        ?int $offset = null,
    ): array;

    /**
     * @return Question[]
     */
    public function findAllByCategoryAndSubcategory(
        string $category,
        string $subcategory,
        ?int $limit = null,
        ?int $offset = null,
    ): array;

    public function findAllToReview(): array;

    public function countAll(?CategoryEnum $category, ?CategoryEnum $subcategory): int;

    public function getQuestionsWithUserRelatedData(
        string $userId,
        CategoryEnum $category,
        ?CategoryEnum $subcategory = null,
        ?int $limit = null,
        ?int $offset = null,
    ): array;
}
