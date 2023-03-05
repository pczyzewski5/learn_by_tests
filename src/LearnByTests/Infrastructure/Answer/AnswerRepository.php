<?php

declare(strict_types=1);

namespace LearnByTests\Infrastructure\Answer;

use Doctrine\ORM\EntityManagerInterface;
use LearnByTests\Domain\Answer\Exception\AnswerNotFoundException;
use LearnByTests\Domain\Answer\Answer as DomainAnswer;
use LearnByTests\Domain\Answer\AnswerRepository as DomainRepository;

class AnswerRepository implements DomainRepository
{
    private EntityManagerInterface $entityManager;

    public function __construct(EntityManagerInterface $entityManager)
    {
        $this->entityManager = $entityManager;
    }

    public function getOneById(string $id): DomainAnswer
    {
        $entity = $this->entityManager->getRepository(Answer::class)->find($id);

        if (null === $entity) {
            throw AnswerNotFoundException::notFound($id);
        }

        return AnswerMapper::toDomain($entity);
    }

    /**
     * @return DomainAnswer[]
     */
    public function findAll(): array
    {
        return AnswerMapper::mapArrayToDomain(
            $this->entityManager->getRepository(Answer::class)->findAll()
        );
    }

    /**
     * @return Answer[]
     */
    public function findForQuestion(string $questionId): array
    {
        $answers = $this->entityManager->getRepository(Answer::class)->findBy([
            'questionId' => $questionId
        ]);

        return AnswerMapper::mapArrayToDomain($answers);
    }
}
