<?php

declare(strict_types=1);

namespace LearnByTests\Infrastructure\Question;

use Doctrine\ORM\EntityManagerInterface;
use LearnByTests\Domain\Question\Exception\QuestionNotFoundException;
use LearnByTests\Domain\Question\Question as DomainQuestion;
use LearnByTests\Domain\Question\QuestionRepository as DomainRepository;

class QuestionRepository implements DomainRepository
{
    private EntityManagerInterface $entityManager;

    public function __construct(EntityManagerInterface $entityManager)
    {
        $this->entityManager = $entityManager;
    }

    public function getOneById(string $id): DomainQuestion
    {
        $entity = $this->entityManager->getRepository(Question::class)->find($id);

        if (null === $entity) {
            throw QuestionNotFoundException::notFound($id);
        }

        return QuestionMapper::toDomain($entity);
    }

    /**
     * @return DomainQuestion[]
     */
    public function findAll(): array
    {
        return QuestionMapper::mapArrayToDomain(
            $this->entityManager->getRepository(Question::class)->findAll()
        );
    }
}
