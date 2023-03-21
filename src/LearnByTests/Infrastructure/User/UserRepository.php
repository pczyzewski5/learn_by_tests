<?php

namespace LearnByTests\Infrastructure\User;

use Doctrine\ORM\EntityManagerInterface;
use Doctrine\ORM\EntityRepository;
use LearnByTests\Domain\User\Exception\UserNotFoundException;
use LearnByTests\Domain\User\UserRepository as DomainRepository;
use LearnByTests\Domain\User\User as DomainUser;

class UserRepository extends EntityRepository implements DomainRepository
{
    public function __construct(EntityManagerInterface $entityManager)
    {
        parent::__construct(
            $entityManager,
            $entityManager->getClassMetadata(User::class)
        );
    }

    public function getOneById(string $id): DomainUser
    {
        $entity = $this->getEntityManager()->getRepository(User::class)->find($id);

        if (null === $entity) {
            throw UserNotFoundException::notFound($id);
        }

        return UserMapper::toDomain($entity);
    }

    public function findAllUsers(): array
    {
        $result = $this->getEntityManager()->getRepository(User::class)->findAll();

        return UserMapper::mapArrayToDomain($result);
    }

    public function findOneById(string $id): ?DomainUser
    {
        $entity = $this->getEntityManager()->getRepository(User::class)->find($id);

        return UserMapper::toDomain($entity) ?? null;
    }

    public function findUserByEmail(string $username): ?DomainUser
    {
        $entity = $this->getEntityManager()->getRepository(User::class)->findOneBy([
            'email' => $username
        ]);

        return null === $entity ? null : UserMapper::toDomain($entity);
    }
}
