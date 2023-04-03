<?php

namespace LearnByTests\Domain\UserSkippedQuestion;

use LearnByTests\Domain\Category\CategoryEnum;
use LearnByTests\Domain\Exception\PersisterException;

interface UserSkippedQuestionPersister
{
    /**
     * @throws PersisterException
     */
    public function save(UserSkippedQuestion $question): void;

    /**
     * @throws PersisterException
     */
    public function deleteAllForUser(string $userId): void;
}
