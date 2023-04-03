<?php

declare(strict_types=1);

namespace LearnByTests\Domain\Command;

use LearnByTests\Domain\User\UserPersister;
use LearnByTests\Domain\User\UserRepository;
use LearnByTests\Domain\UserQuestionAnswer\UserQuestionAnswerPersister;
use LearnByTests\Domain\UserSkippedQuestion\UserSkippedQuestionPersister;

class DeleteUserHandler
{
    private UserRepository $userRepository;
    private UserPersister $userPersister;
    private UserQuestionAnswerPersister $userQuestionAnswerPersister;
    private UserSkippedQuestionPersister $userSkippedQuestionPersister;

    public function __construct(
        UserRepository $userRepository,
        UserPersister $userPersister,
        UserQuestionAnswerPersister $userQuestionAnswerPersister,
        UserSkippedQuestionPersister $userSkippedQuestionPersister,
    ) {
        $this->userRepository = $userRepository;
        $this->userPersister = $userPersister;
        $this->userQuestionAnswerPersister = $userQuestionAnswerPersister;
        $this->userSkippedQuestionPersister = $userSkippedQuestionPersister;
    }

    public function handle(DeleteUser $command): void
    {
        $this->userPersister->delete(
            $this->userRepository->getOneById(
                $command->getUserId()
            )
        );
        $this->userQuestionAnswerPersister->deleteAllForUser(
            $command->getUserId()
        );
        $this->userSkippedQuestionPersister->deleteAllForUser(
            $command->getUserId()
        );
    }
}
