<?php

declare(strict_types=1);

namespace LearnByTests\Domain\User;

use LearnByTests\Domain\MergerTrait;
use LearnByTests\Domain\User\Exception\UserValidationException;
use Symfony\Component\Security\Core\User\PasswordAuthenticatedUserInterface;
use Symfony\Component\Security\Core\User\UserInterface;
use Symfony\Component\Uid\UuidV1;

class User implements UserInterface, PasswordAuthenticatedUserInterface
{
    use MergerTrait;

    private string $id;
    private string $email;
    private array $roles;
    private bool $isActive;
    private string $password;
    private \DateTimeImmutable $createdAt;

    public function __construct(UserDTO $dto)
    {
        $this->merge($dto);
    }

    public function update(UserDTO $dto): void
    {
        $this->merge($dto);
        $this->validate();
    }

    private function validate(): void
    {
        // @todo fix validation, ex password cant be empty
        if (!isset($this->id) && UuidV1::isValid($this->id)) {
            throw UserValidationException::missingProperty('id');
        }
        
        if (!isset($this->email) || '' === $this->email) {
            throw UserValidationException::missingProperty('email');
        }

        if (!isset($this->roles) || empty($this->roles)) {
            throw UserValidationException::missingProperty('roles');
        }

        if (!isset($this->password) || '' === $this->password) {
            throw UserValidationException::missingProperty('password');
        }

        if (!\is_bool($this->isActive)) {
            throw UserValidationException::missingProperty('is_active');
        }

        if (!isset($this->createdAt)) {
            throw UserValidationException::missingProperty('createdAt');
        }
    }

    public function getId(): string
    {
        return $this->id;
    }

    public function getEmail(): string
    {
        return $this->email;
    }

    public function getRoles(): array
    {
        return $this->roles;
    }

    public function getPassword(): string
    {
        return $this->password;
    }

    public function isActive(): bool
    {
        return $this->isActive;
    }

    public function getCreatedAt(): \DateTimeImmutable
    {
        return $this->createdAt;
    }

    /**
     * Returning a salt is only needed, if you are not using a modern
     * hashing algorithm (e.g. bcrypt or sodium) in your security.yaml.
     *
     * @see UserInterface
     */
    public function getSalt(): ?string
    {
        return null;
    }

    /**
     * @see UserInterface
     */
    public function eraseCredentials()
    {
        // If you store any temporary, sensitive data on the user, clear it here
        // $this->plainPassword = null;
    }

    /**
     * A visual identifier that represents this user.
     *
     * @see UserInterface
     */
    public function getUserIdentifier(): string
    {
        return $this->email;
    }

    /**
     * @deprecated since Symfony 5.3, use getUserIdentifier instead
     */
    public function getUsername(): string
    {
        return $this->email;
    }
}
