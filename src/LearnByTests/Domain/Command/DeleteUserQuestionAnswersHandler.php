<?php

declare(strict_types=1);

namespace LearnByTests\Domain\Command;

use LearnByTests\Domain\User\UserDTO;
use LearnByTests\Domain\User\UserPersister;
use LearnByTests\Domain\User\UserRepository;
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
            $command->getCategory()->getValue(),
            $command->getSubcategory() === null ? null : $command->getSubcategory()->getValue()
        );
    }
}
