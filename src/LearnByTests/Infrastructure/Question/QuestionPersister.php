<?php

declare(strict_types=1);

namespace LearnByTests\Infrastructure\Question;

use Doctrine\ORM\EntityManagerInterface;
use LearnByTests\Domain\Question\QuestionPersister as DomainPersister;
use LearnByTests\Domain\Question\Question;
use LearnByTests\Domain\Exception\PersisterException;

class QuestionPersister implements DomainPersister
{
    private EntityManagerInterface $entityManager;

    public function __construct(EntityManagerInterface $entityManager)
    {
        $this->entityManager = $entityManager;
    }

    /**
     * @throws PersisterException
     */
    public function save(Question $question): void
    {
        $entity = QuestionMapper::fromDomain($question);

        try {
            $this->entityManager->persist($entity);
            $this->entityManager->flush();
        } catch (\Throwable $exception) {
            throw PersisterException::fromThrowable($exception);
        }
    }

    /**
     * @throws PersisterException
     */
    public function delete(string $id): void
    {

    }
}
