<?php

namespace LearnByTests\Domain\UserQuestionAnswer;

use LearnByTests\Domain\Category\CategoryEnum;
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
        CategoryEnum $category,
        CategoryEnum $subcategory,
    ): void;
}
