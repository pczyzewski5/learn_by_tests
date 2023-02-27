<?php

namespace LearnByTests\Domain\Question;

use LearnByTests\Domain\Exception\PersisterException;

interface QuestionPersister
{
    /**
     * @throws PersisterException
     */
    public function save(Question $answer): void;

    /**
     * @throws PersisterException
     */
    public function delete(string $id): void;
}
