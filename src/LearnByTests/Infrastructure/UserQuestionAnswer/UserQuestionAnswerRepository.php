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
        $entity = $this->entityManager->getRepository(UserQuestionAnswer::class)->findOneBy([
            'userId' => $userId,
            'questionId' => $questionId
        ]);

        if (null === $entity) {
            return null;
        }

        return UserQuestionAnswerMapper::toDomain($entity);
    }

    public function findAllQuestionIds(string $userId): array
    {
        $qb = $this->entityManager->createQueryBuilder();
        $query = $qb
            ->select('uqa.questionId')
            ->from(UserQuestionAnswer::class, 'uqa')
            ->where('uqa.userId = :userId')
            ->setParameter('userId', $userId)
            ->getQuery();

        $result = [];

        foreach ($query->getResult() as $item) {
            $result[] = $item['questionId'];
        }

        return $result;
    }
}
