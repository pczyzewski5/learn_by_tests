<?php

declare(strict_types=1);

namespace LearnByTests\Domain\Command;

use LearnByTests\Domain\Question\QuestionPersister;

class DeleteQuestionHandler
{
    private QuestionPersister $questionPersister;

    public function __construct(QuestionPersister $questionPersister) {
        $this->questionPersister = $questionPersister;
    }

    public function handle(DeleteQuestion $command): void
    {
        $this->questionPersister->delete($command->getQuestionId());
    }
}
