<?php

declare(strict_types=1);

namespace LearnByTests\Infrastructure\UserQuestionAnswer;

use Doctrine\DBAL\Types\Types;
use Doctrine\ORM\EntityManagerInterface;
use LearnByTests\Domain\Category\CategoryEnum;
use LearnByTests\Domain\UserQuestionAnswer\UserQuestionAnswerPersister as DomainPersister;
use LearnByTests\Domain\Exception\PersisterException;
use LearnByTests\Domain\UserQuestionAnswer\UserQuestionAnswer;

class UserQuestionAnswerPersister implements DomainPersister
{
    private EntityManagerInterface $entityManager;

    public function __construct(EntityManagerInterface $entityManager)
    {
        $this->entityManager = $entityManager;
    }

    /**
     * @throws PersisterException
     */
    public function save(UserQuestionAnswer $question): void
    {
        $entity = UserQuestionAnswerMapper::fromDomain($question);

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
    public function deleteAllForUser(string $userId): void
    {
        try {
            $this->entityManager->getConnection()->executeQuery(
                'DELETE FROM questions WHERE id = ?',
                [$userId],
                [Types::STRING]
            );
        } catch (\Throwable $exception) {
            throw PersisterException::fromThrowable($exception);
        }
    }

    /**
     * @throws PersisterException
     */
    public function deleteAllByCategoryAndSubcategory(
        string $userId,
        string $category,
        ?string $subcategory,
    ): void {
        try {
            $this->entityManager->getConnection()->executeQuery(
                'DELETE uqa FROM user_question_answers uqa JOIN questions q on q.id = uqa.question_id
                        WHERE uqa.user_id = :userId
                        AND q.category = :category
                        AND q.subcategory LIKE :subcategory',
                [
                    'userId' => $userId,
                    'category' => $category,
                    'subcategory' => null === $subcategory ? '%' : $subcategory
                ],
                [
                    'userId' => Types::STRING,
                    'category' => Types::STRING,
                    'subcategory' => Types::STRING,
                ]
            );
        } catch (\Throwable $exception) {
            throw PersisterException::fromThrowable($exception);
        }
    }
}
