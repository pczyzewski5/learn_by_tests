<?php

declare(strict_types=1);

namespace LearnByTests\Domain\Command;

use LearnByTests\Domain\Answer\AnswerPersister;

class DeleteAnswerHandler
{
    private AnswerPersister $answerPersister;

    public function __construct(
        AnswerPersister $answerPersister
    ) {
        $this->answerPersister = $answerPersister;
    }

    public function handle(DeleteAnswer $command): void
    {
        $this->answerPersister->delete($command->getAnswerId());
    }
}
