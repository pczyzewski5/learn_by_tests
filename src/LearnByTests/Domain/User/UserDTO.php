<?php

declare(strict_types=1);

namespace LearnByTests\Domain\User;

class UserDTO
{
    public ?string $id = null;
    public ?string $email = null;
    public ?array $roles = null;
    public ?string $password = null;
    public ?\DateTimeImmutable $createdAt = null;
}
