<?php

declare(strict_types=1);

namespace LearnByTests\Infrastructure\UserQuestionAnswer;

use Doctrine\ORM\EntityManagerInterface;
use LearnByTests\Domain\UserQuestionAnswer\UserQuestionAnswer as DomainUserQuestionAnswer;
use LearnByTests\Domain\UserQuestionAnswer\UserQuestionAnswerRepository as DomainRepository;

class UserQuestionAnswerRepository implements DomainRepository
{
    private EntityManagerInterface $entityManager;

    public function __construct(EntityManagerInterface $entityManager)
    {
        $this->entityManager = $entityManager;
    }

    public function findOne(string $userId, string $questionId): ?DomainUserQuestionAnswer
    {
        $entity = $this->entityManager->getRepository(UserQuestionAnswer::class)->find($userId);

        if (null === $entity) {
            return null;
        }

        return UserQuestionAnswerMapper::toDomain($entity);
    }
}
