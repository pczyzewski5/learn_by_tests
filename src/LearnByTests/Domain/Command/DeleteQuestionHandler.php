<?php

declare(strict_types=1);

namespace LearnByTests\Domain\Command;

use LearnByTests\Domain\Answer\AnswerPersister;
use LearnByTests\Domain\Question\QuestionPersister;
use LearnByTests\Domain\UserQuestionAnswer\UserQuestionAnswerPersister;
use LearnByTests\Domain\UserSkippedQuestion\UserSkippedQuestionPersister;

class DeleteQuestionHandler
{
    private QuestionPersister $questionPersister;
    private AnswerPersister $answerPersister;
    private UserQuestionAnswerPersister $userQuestionAnswerPersister;
    private UserSkippedQuestionPersister $userSkippedQuestionPersister;

    public function __construct(
        QuestionPersister $questionPersister,
        AnswerPersister $answerPersister,
        UserQuestionAnswerPersister $userQuestionAnswerPersister,
        UserSkippedQuestionPersister $userSkippedQuestionPersister,
    ) {
        $this->questionPersister = $questionPersister;
        $this->answerPersister = $answerPersister;
        $this->userQuestionAnswerPersister = $userQuestionAnswerPersister;
        $this->userSkippedQuestionPersister = $userSkippedQuestionPersister;
    }

    public function handle(DeleteQuestion $command): void
    {
        $this->userQuestionAnswerPersister->deleteAllByQuestionId($command->getQuestionId());
        $this->questionPersister->delete($command->getQuestionId());
        $this->answerPersister->deleteAnswersForQuestion($command->getQuestionId());
        $this->userSkippedQuestionPersister->deleteAllByQuestionId($command->getQuestionId());
    }
}
