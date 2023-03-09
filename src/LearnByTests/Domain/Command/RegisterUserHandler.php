<?php

declare(strict_types=1);

namespace LearnByTests\Domain\Command;

use LearnByTests\Domain\Exception\PersisterException;
use LearnByTests\Domain\User\Exception\UserAlreadyExistsException;
use LearnByTests\Domain\User\UserDTO;
use LearnByTests\Domain\User\UserFactory;
use LearnByTests\Domain\User\UserPersister;
use Symfony\Component\PasswordHasher\Hasher\UserPasswordHasherInterface;

class RegisterUserHandler
{
    private UserPasswordHasherInterface $userPasswordHasher;
    private UserPersister $userPersister;

    public function __construct(
        UserPasswordHasherInterface $userPasswordHasher,
        UserPersister $userPersister
    ) {
        $this->userPasswordHasher = $userPasswordHasher;
        $this->userPersister = $userPersister;
    }

    public function handle(RegisterUser $command): void
    {
        $user = UserFactory::create(
            $command->getEmail(),
            [$command->getRole()],
            $command->getPassword(),
            $command->isActive()
        );

        $hashedPassword = $this->userPasswordHasher->hashPassword(
            $user,
            $command->getPassword()
        );

        $dto = new UserDTO();
        $dto->password = $hashedPassword;

        $user->update($dto);

        try {
            $this->userPersister->save($user);
        } catch (PersisterException $e) {
            throw new UserAlreadyExistsException();
        }
    }
}
