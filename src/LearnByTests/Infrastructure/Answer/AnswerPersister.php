<?php

declare(strict_types=1);

namespace LearnByTests\Infrastructure\Answer;

use Doctrine\DBAL\Types\Types;
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
                  SET answer = :answer, author_id = :authorId, is_correct = :isCorrect
                  WHERE id = :id;';

            $this->entityManager->getConnection()->executeQuery(
                $sql,
                [
                    'id' => $answer->getId(),
                    'answer' => $answer->getAnswer(),
                    'authorId' => $answer->getAuthorId(),
                    'isCorrect' => (int)$answer->isCorrect()
                ],
                [
                    'id' => Types::STRING,
                    'answer' => Types::STRING,
                    'authorId' => Types::STRING,
                    'isCorrect' => Types::BOOLEAN
                ]
            );
        } catch (\Throwable $exception) {
            throw PersisterException::fromThrowable($exception);
        }
    }

    /**
     * @throws PersisterException
     */
    public function delete(string $answerId): void
    {
        try {
            $this->entityManager->getConnection()->executeQuery(
                'DELETE FROM answers WHERE id = ?',
                [$answerId],
                [Types::STRING]
            );
        } catch (\Throwable $exception) {
            throw PersisterException::fromThrowable($exception);
        }
    }

    public function deleteAnswersForQuestion(string $questionId): void
    {
        try {
            $this->entityManager->getConnection()->executeQuery(
                'DELETE FROM answers WHERE question_id = ?',
                [$questionId],
                [Types::STRING]
            );
        } catch (\Throwable $exception) {
            throw PersisterException::fromThrowable($exception);
        }
    }
}
