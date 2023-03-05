<?php

declare(strict_types=1);

namespace LearnByTests\Infrastructure\Answer;

use Doctrine\ORM\EntityManagerInterface;
use LearnByTests\Domain\Answer\AnswerPersister as DomainPersister;
use LearnByTests\Domain\Answer\Answer;
use LearnByTests\Domain\Exception\PersisterException;

class AnswerPersister implements DomainPersister
{
    private EntityManagerInterface $entityManager;

    public function __construct(EntityManagerInterface $entityManager)
    {
        $this->entityManager = $entityManager;
    }

    /**
     * @throws PersisterException
     */
    public function save(Answer $answer): void
    {
        $entity = AnswerMapper::fromDomain($answer);

        try {
            $this->entityManager->persist($entity);
            $this->entityManager->flush();
        } catch (\Throwable $exception) {
            throw PersisterException::fromThrowable($exception);
        }
    }

    public function update(Answer $answer): void
    {
        try {
            $sql = 'UPDATE answers
                  SET answer = :answer, is_valid = :isValid
                  WHERE id = :id;';

            $stmt = $this->entityManager->getConnection()->prepare($sql);
            $stmt->executeStatement([
                'id' => $answer->getId(),
                'answer' => $answer->getAnswer(),
                'isValid' => (int)$answer->isValid()
            ]);
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
