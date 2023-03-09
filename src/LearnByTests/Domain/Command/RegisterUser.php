<?php

declare(strict_types=1);

namespace LearnByTests\Domain\Command;

class RegisterUser
{
    private string $email;
    private string $role;
    private string $password;
    private bool $isActive;

    public function __construct(
        string $email,
        string $role,
        string $password,
        bool $isActive,
    ) {
        $this->email = $email;
        $this->role = $role;
        $this->password = $password;
        $this->isActive = $isActive;
    }

    public function getEmail(): string
    {
        return $this->email;
    }

    public function getRole(): string
    {
        return $this->role;
    }

    public function getPassword(): string
    {
        return $this->password;
    }

    public function isActive(): bool
    {
        return $this->isActive;
    }
}
