<?php

declare(strict_types=1);

namespace LearnByTests\Domain\Answer;

use LearnByTests\Domain\Exception\PersisterException;

interface AnswerPersister
{
    /**
     * @throws PersisterException
     */
    public function save(Answer $answer): void;

    /**
     * @throws PersisterException
     */
    public function update(Answer $answer): void;

    /**
     * @throws PersisterException
     */
    public function delete(string $answerId): void;

    /**
     * @throws PersisterException
     */
    public function deleteAnswersForQuestion(string $questionId): void;
}
