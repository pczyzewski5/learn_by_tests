<?php

declare(strict_types=1);

namespace LearnByTests\Domain\Command;

use LearnByTests\Domain\UserSkippedQuestion\UserSkippedQuestionFactory;
use LearnByTests\Domain\UserSkippedQuestion\UserSkippedQuestionPersister;
use LearnByTests\Domain\UserSkippedQuestion\UserSkippedQuestionRepository;

class ToggleSkipQuestionHandler
{
    private UserSkippedQuestionPersister $persister;
    private UserSkippedQuestionRepository $repository;

    public function __construct(
        UserSkippedQuestionPersister $persister,
        UserSkippedQuestionRepository $repository,
    ) {
        $this->persister = $persister;
        $this->repository = $repository;
    }

    public function handle(ToggleSkipQuestion $command): void
    {
        $userId = $command->getUserId();
        $questionId = $command->getQuestionId();
        $isSkipped = $this->repository->isSkipped($userId, $questionId);

        if ($isSkipped) {
            $this->persister->deleteByUserIdAndQuestionId($userId, $questionId);
        } else {
            $this->persister->save(
                UserSkippedQuestionFactory::create($userId, $questionId)
            );
        }
    }
}
