<?php

declare(strict_types=1);

namespace LearnByTests\Infrastructure\UserSkippedQuestion;

use Doctrine\ORM\EntityManagerInterface;
use LearnByTests\Domain\UserSkippedQuestion\UserSkippedQuestion as DomainEntity;
use LearnByTests\Domain\UserSkippedQuestion\UserSkippedQuestionRepository as DomainRepository;

class UserSkippedQuestionRepository implements DomainRepository
{
    private EntityManagerInterface $entityManager;

    public function __construct(EntityManagerInterface $entityManager)
    {
        $this->entityManager = $entityManager;
    }

    public function findOne(string $userId, string $questionId): ?DomainEntity
    {
        $entity = $this->entityManager->getRepository(UserSkippedQuestion::class)->findOneBy([
            'userId' => $userId,
            'questionId' => $questionId
        ]);

        if (null === $entity) {
            return null;
        }

        return UserSkippedQuestionMapper::toDomain($entity);
    }
}
