<?php

declare(strict_types=1);

namespace LearnByTests\Infrastructure\Question;

use Doctrine\DBAL\Types\Types;
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

    public function update(Question $question): void
    {
        try {
            $sql = 'UPDATE questions
                  SET question = :question,
                      author_id = :authorId,
                      category = :category,
                      subcategory = :subcategory,
                      toReview = :toReview
                  WHERE id = :id;';

            $this->entityManager->getConnection()->executeQuery(
                $sql,
                [
                    'id' => $question->getId(),
                    'question' => $question->getQuestion(),
                    'authorId' => $question->getAuthorId(),
                    'category' => $question->getCategory()->getLowerKey(),
                    'subcategory' => $question->getSubcategory()->getLowerKey(),
                    'toReview' => $question->toReview(),
                ],
                [
                    'id' => Types::STRING,
                    'question' => Types::STRING,
                    'authorId' => Types::STRING,
                    'category' => Types::STRING,
                    'subcategory' => Types::STRING,
                    'toReview' => Types::BOOLEAN,
                ]
            );
        } catch (\Throwable $exception) {
            throw PersisterException::fromThrowable($exception);
        }
    }

    /**
     * @throws PersisterException
     */
    public function delete(string $id): void
    {
        try {
            $this->entityManager->getConnection()->executeQuery(
                'DELETE FROM questions WHERE id = ?',
                [$id],
                [Types::STRING]
            );
        } catch (\Throwable $exception) {
            throw PersisterException::fromThrowable($exception);
        }
    }
}
