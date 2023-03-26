<?php

declare(strict_types=1);

namespace LearnByTests\Domain\Command;

use LearnByTests\Domain\UserQuestionAnswer\UserQuestionAnswerFactory;
use LearnByTests\Domain\UserQuestionAnswer\UserQuestionAnswerPersister;

class CreateUserQuestionAnswerHandler
{
    private UserQuestionAnswerPersister $persister;

    public function __construct(UserQuestionAnswerPersister $persister) {
        $this->persister = $persister;
    }

    public function handle(CreateUserQuestionAnswer $command): void
    {
        $entity = UserQuestionAnswerFactory::create(
            $command->getUserId(),
            $command->getQuestionId(),
            $command->getAnswerId()
        );

        $this->persister->save($entity);
    }
}
