<?php

declare(strict_types=1);

namespace LearnByTests\Infrastructure\User;

class User
{
    public ?string $id;
    public ?string $email;
    public ?string $roles;
    public ?string $password;
    public ?bool $isActive;
    public ?\DateTime $createdAt;
}
