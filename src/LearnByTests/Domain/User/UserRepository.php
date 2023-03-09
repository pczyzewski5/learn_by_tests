<?php

declare(strict_types=1);

namespace LearnByTests\Domain\User;

interface UserRepository
{
    public function findOneById(string $id): ?User;

    public function findActiveUserByEmail(string $username): ?User;
}
