<?php

declare(strict_types=1);

namespace LearnByTests\Domain\Command;

use LearnByTests\Domain\User\UserPersister;
use LearnByTests\Domain\User\UserRepository;

class DeleteUserHandler
{
    private UserRepository $userRepository;
    private UserPersister $userPersister;

    public function __construct(
        UserRepository $userRepository,
        UserPersister $userPersister
    ) {
        $this->userRepository = $userRepository;
        $this->userPersister = $userPersister;
    }

    public function handle(DeleteUser $command): void
    {
        $this->userPersister->delete(
            $this->userRepository->getOneById($command->getUserId())
        );
    }
}
