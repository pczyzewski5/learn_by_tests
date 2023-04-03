<?php

declare(strict_types=1);

namespace LearnByTests\Infrastructure\UserSkippedQuestion;

use Doctrine\ORM\EntityManagerInterface;
use LearnByTests\Domain\UserSkippedQuestion\UserSkippedQuestionPersister as DomainPersister;
use LearnByTests\Domain\Exception\PersisterException;
use LearnByTests\Domain\UserSkippedQuestion\UserSkippedQuestion;

class UserSkippedQuestionPersister implements DomainPersister
{
    private EntityManagerInterface $entityManager;

    public function __construct(EntityManagerInterface $entityManager)
    {
        $this->entityManager = $entityManager;
    }

    /**
     * @throws PersisterException
     */
    public function save(UserSkippedQuestion $question): void
    {
        $entity = UserSkippedQuestionMapper::fromDomain($question);

        try {
            $this->entityManager->persist($entity);
            $this->entityManager->flush();
        } catch (\Throwable $exception) {
            throw PersisterException::fromThrowable($exception);
        }
    }

    public function deleteAllByQuestionId(string $questionId): void
    {

    }
}
