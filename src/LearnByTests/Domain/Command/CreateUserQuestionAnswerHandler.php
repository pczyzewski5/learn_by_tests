<?php

declare(strict_types=1);

namespace LearnByTests\Domain\Command;

use LearnByTests\Domain\UserQuestionAnswer\UserQuestionAnswerFactory;
use LearnByTests\Domain\UserQuestionAnswer\UserQuestionAnswerPersister;
use LearnByTests\Domain\UserQuestionAnswer\UserQuestionAnswerRepository;

class CreateUserQuestionAnswerHandler
{
    private UserQuestionAnswerRepository $repository;
    private UserQuestionAnswerPersister $persister;

    public function __construct(
        UserQuestionAnswerRepository $repository,
        UserQuestionAnswerPersister $persister
    ) {
        $this->repository = $repository;
        $this->persister = $persister;
    }

    public function handle(CreateUserQuestionAnswer $command): void
    {
        if (null === $this->repository->findOne($command->getUserId(), $command->getQuestionId())) {

            $entity = UserQuestionAnswerFactory::create(
                $command->getUserId(),
                $command->getQuestionId(),
                $command->getAnswerId()
            );

            $this->persister->save($entity);
        }
    }
}
