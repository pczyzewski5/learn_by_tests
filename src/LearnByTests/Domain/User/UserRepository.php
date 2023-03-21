<?php

declare(strict_types=1);

namespace LearnByTests\Domain\User;

use LearnByTests\Domain\User\Exception\UserNotFoundException;

interface UserRepository
{
    /**
     * @throws UserNotFoundException
     */
    public function getOneById(string $id): User;

    /**
     * @return User[]
     */
    public function findAllUsers(): array;

    public function findOneById(string $id): ?User;

    public function findUserByEmail(string $username): ?User;
}
