<?php

declare(strict_types=1);

namespace LearnByTests\Domain\Command;

use LearnByTests\Domain\User\UserDTO;
use LearnByTests\Domain\User\UserPersister;
use LearnByTests\Domain\User\UserRepository;

class DeactivateUserHandler
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

    public function handle(DeactivateUser $command): void
    {
        $dto = new UserDTO();
        $dto->isActive = false;

        $user = $this->userRepository->getOneById($command->getUserId());
        $user->update($dto);

        $this->userPersister->update($user);
    }
}
