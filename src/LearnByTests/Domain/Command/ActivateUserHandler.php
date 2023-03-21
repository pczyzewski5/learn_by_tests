<?php

declare(strict_types=1);

namespace LearnByTests\Domain\Command;

use LearnByTests\Domain\User\UserDTO;
use LearnByTests\Domain\User\UserPersister;
use LearnByTests\Domain\User\UserRepository;

class ActivateUserHandler
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

    public function handle(ActivateUser $command): void
    {
        $dto = new UserDTO();
        $dto->isActive = true;

        $user = $this->userRepository->getOneById($command->getUserId());
        $user->update($dto);

        $this->userPersister->update($user);
    }
}
