<?php

declare(strict_types=1);

namespace LearnByTests\Infrastructure\User;

use Doctrine\DBAL\Types\Types;
use LearnByTests\Domain\Exception\PersisterException;
use LearnByTests\Domain\User\User;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Component\Security\Core\User\PasswordAuthenticatedUserInterface;
use Symfony\Component\Security\Core\User\PasswordUpgraderInterface;
use LearnByTests\Domain\User\UserPersister as DomainPersister;
use Symfony\Component\Security\Core\User\UserInterface;

class UserPersister implements DomainPersister, PasswordUpgraderInterface
{
    private EntityManagerInterface $entityManager;

    public function __construct(EntityManagerInterface $entityManager)
    {
        $this->entityManager = $entityManager;
    }

    public function save(User $user): void
    {
        $entity = UserMapper::fromDomain($user);

        try {
            $this->entityManager->persist($entity);
            $this->entityManager->flush();
        } catch (\Throwable $exception) {
            throw PersisterException::fromThrowable($exception);
        }
    }

    public function update(User $user): void
    {
        try {
            $sql = 'UPDATE users
                  SET is_active = :isActive
                  WHERE id = :id;';

            $this->entityManager->getConnection()->executeQuery(
                $sql,
                [
                    'id' => $user->getId(),
                    'isActive' => $user->isActive(),
                ],
                [
                    'id' => Types::STRING,
                    'isActive' => Types::BOOLEAN,
                ]
            );
        } catch (\Throwable $exception) {
            throw PersisterException::fromThrowable($exception);
        }
    }

    public function delete(User $user): void
    {
        try {
            $this->entityManager->getConnection()->executeQuery(
                'DELETE FROM users WHERE id = ?',
                [$user->getId()],
                [Types::STRING]
            );
        } catch (\Throwable $exception) {
            throw PersisterException::fromThrowable($exception);
        }
    }

    public function upgradePassword(
        UserInterface|PasswordAuthenticatedUserInterface $user,
        string $newHashedPassword
    ): void {
        throw new \Exception('not implemented');
    }
}
