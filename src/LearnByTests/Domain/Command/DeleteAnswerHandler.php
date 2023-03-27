<?php

declare(strict_types=1);

namespace LearnByTests\Domain\Command;

use LearnByTests\Domain\Answer\AnswerPersister;
use LearnByTests\Domain\UserQuestionAnswer\UserQuestionAnswerPersister;

class DeleteAnswerHandler
{
    private AnswerPersister $answerPersister;
    private UserQuestionAnswerPersister $userQuestionAnswerPersister;

    public function __construct(
        AnswerPersister $answerPersister,
        UserQuestionAnswerPersister $userQuestionAnswerPersister
    ) {
        $this->answerPersister = $answerPersister;
        $this->userQuestionAnswerPersister = $userQuestionAnswerPersister;
    }

    public function handle(DeleteAnswer $command): void
    {
        $this->userQuestionAnswerPersister->deleteAllByAnswerId($command->getAnswerId());
        $this->answerPersister->delete($command->getAnswerId());
    }
}
