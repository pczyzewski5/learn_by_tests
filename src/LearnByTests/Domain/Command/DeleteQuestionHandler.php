<?php

declare(strict_types=1);

namespace LearnByTests\Domain\Command;

use LearnByTests\Domain\Answer\AnswerPersister;
use LearnByTests\Domain\Question\QuestionPersister;
use LearnByTests\Domain\UserQuestionAnswer\UserQuestionAnswerPersister;

class DeleteQuestionHandler
{
    private QuestionPersister $questionPersister;
    private AnswerPersister $answerPersister;
    private UserQuestionAnswerPersister $userQuestionAnswerPersister;

    public function __construct(
        QuestionPersister $questionPersister,
        AnswerPersister $answerPersister,
        UserQuestionAnswerPersister $userQuestionAnswerPersister
    ) {
        $this->questionPersister = $questionPersister;
        $this->answerPersister = $answerPersister;
        $this->userQuestionAnswerPersister = $userQuestionAnswerPersister;
    }

    public function handle(DeleteQuestion $command): void
    {
        $this->userQuestionAnswerPersister->deleteAllByQuestionId($command->getQuestionId());
        $this->questionPersister->delete($command->getQuestionId());
        $this->answerPersister->deleteAnswersForQuestion($command->getQuestionId());
    }
}
