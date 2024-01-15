<?php

declare(strict_types=1);

namespace LearnByTests\Domain\Question;

use LearnByTests\Domain\Exception\PersisterException;

interface QuestionPersister
{
    /**
     * @throws PersisterException
     */
    public function save(Question $question): void;

    /**
     * @throws PersisterException
     */
    public function update(Question $question): void;

    /**
     * @throws PersisterException
     */
    public function delete(string $id): void;
}
