<?php

declare(strict_types=1);

namespace LearnByTests\Domain\User;

use Symfony\Component\Uid\Uuid;

class UserFactory
{
    public static function create(
        string $email,
        array $roles,
        string $password,
        bool $isActive,
    ): User {
        $dto = new UserDTO();
        $dto->id = Uuid::v1()->toRfc4122();
        $dto->email = $email;
        $dto->roles = $roles;
        $dto->password = $password;
        $dto->isActive = $isActive;
        $dto->createdAt = new \DateTimeImmutable();

        return new User($dto);
    }
}
