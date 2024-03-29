<?php

declare(strict_types=1);

namespace LearnByTests\Domain\UserQuestionAnswer;

use LearnByTests\Domain\Exception\PersisterException;

interface UserQuestionAnswerPersister
{
    /**
     * @throws PersisterException
     */
    public function save(UserQuestionAnswer $question): void;

    /**
     * @throws PersisterException
     */
    public function deleteAllForUser(string $userId): void;

    /**
     * @throws PersisterException
     */
    public function deleteAllByCategoryAndSubcategory(
        string $userId,
        string $category,
        string $subcategory,
    ): void;

    /**
     * @throws PersisterException
     */
    public function deleteAllByQuestionId(string $questionId): void;

    /**
     * @throws PersisterException
     */
    public function deleteAllByAnswerId(string $answerId): void;
}
