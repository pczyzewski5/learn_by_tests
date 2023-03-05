<?php

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
    public function delete(string $id): void;
}
