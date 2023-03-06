<?php

declare(strict_types=1);

namespace LearnByTests\Domain\Command;

use LearnByTests\Domain\Answer\AnswerPersister;
use LearnByTests\Domain\Question\QuestionPersister;

class DeleteQuestionHandler
{
    private QuestionPersister $questionPersister;
    private AnswerPersister $answerPersister;

    public function __construct(
        QuestionPersister $questionPersister,
        AnswerPersister $answerPersister
    ) {
        $this->questionPersister = $questionPersister;
        $this->answerPersister = $answerPersister;
    }

    public function handle(DeleteQuestion $command): void
    {
        $this->questionPersister->delete($command->getQuestionId());
        $this->answerPersister->deleteAnswersForQuestion($command->getQuestionId());
    }
}
