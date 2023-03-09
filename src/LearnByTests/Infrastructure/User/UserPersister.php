<?php

namespace LearnByTests\Infrastructure\User;

use LearnByTests\Domain\Exception\PersisterException;
use LearnByTests\Domain\User\User;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Component\Security\Core\User\PasswordUpgraderInterface;
use LearnByTests\Domain\User\UserPersister as DomainPersister;

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
}
