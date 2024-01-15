<?php

declare(strict_types=1);

namespace LearnByTests\Domain\Command;

use LearnByTests\Domain\UserQuestionAnswer\UserQuestionAnswerPersister;

class DeleteUserQuestionAnswersHandler
{
    private UserQuestionAnswerPersister $persister;

    public function __construct(
        UserQuestionAnswerPersister $persister
    ) {
        $this->persister = $persister;
    }

    public function handle(DeleteUserQuestionAnswers $command): void
    {
        $this->persister->deleteAllByCategoryAndSubcategory(
            $command->getUserId(),
            $command->getCategory()->getLowerKey(),
            $command->getSubcategory() === null ? null : $command->getSubcategory()->getLowerKey()
        );
    }
}
