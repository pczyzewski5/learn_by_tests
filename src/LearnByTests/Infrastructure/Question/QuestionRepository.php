<?php

declare(strict_types=1);

namespace LearnByTests\Infrastructure\Question;

use Doctrine\DBAL\Types\Types;
use Doctrine\ORM\EntityManagerInterface;
use LearnByTests\Domain\Category\CategoryEnum;
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

    /**
     * @return DomainQuestion[]
     */
    public function findAllByCategory(
        string $category,
        ?int $limit = null,
        ?int $offset = null,
    ): array {
        return QuestionMapper::mapArrayToDomain(
            $this->entityManager->getRepository(Question::class)->findBy(
                ['category' => $category],
                ['createdAt' => 'DESC'],
                $limit,
                $offset
            )
        );
    }

    /**
     * @return DomainQuestion[]
     */
    public function findAllByCategoryAndSubcategory(
        string $category,
        string $subcategory,
        ?int $limit = null,
        ?int $offset = null,
    ): array {
        return QuestionMapper::mapArrayToDomain(
            $this->entityManager->getRepository(Question::class)->findBy(
                ['category' => $category, 'subcategory' => $subcategory],
                ['createdAt' => 'DESC'],
                $limit,
                $offset
            )
        );
    }

    public function findAllToReview(): array
    {
        return QuestionMapper::mapArrayToDomain(
            $this->entityManager->getRepository(Question::class)->findBy(
                ['toReview' => true],
                ['createdAt' => 'DESC']
            )
        );
    }

    public function countAll(?CategoryEnum $category, ?CategoryEnum $subcategory): int
    {
        $criteria = [];

        if (null !== $category) {
            $criteria = \array_merge($criteria, ['category' => $category->getLowerKey()]);
        }
        if (null !== $subcategory) {
            $criteria = \array_merge($criteria, ['subcategory' => $subcategory->getLowerKey()]);
        }

        return $this->entityManager->getRepository(Question::class)->count($criteria);
    }

    public function getQuestionsWithUserRelatedData(
        string $userId,
        CategoryEnum $category,
        ?CategoryEnum $subcategory = null,
        ?int $limit = null,
        ?int $offset = null,
    ): array {
        $sql = 'SELECT q.id, q.question, q.category, q.subcategory, a.is_correct, (usq.question_id IS NOT NULL) as is_skipped 
                FROM questions q
                    LEFT JOIN user_question_answers uqa ON q.id = uqa.question_id AND (uqa.user_id = :userId OR uqa.user_id IS NULL)
                    LEFT JOIN answers a ON a.id = uqa.answer_id
                    LEFT JOIN user_skipped_questions usq ON usq.question_id = q.id AND (usq.user_id = :userId OR usq.user_id IS NULL)
                WHERE q.category = :category
                    AND q.subcategory LIKE :subcategory
                ORDER BY q.created_at DESC';

        if (null !== $limit) {
            $sql .= PHP_EOL . 'LIMIT ' . $limit;
        }
        if (null !== $offset) {
            $sql .= PHP_EOL . 'OFFSET ' . $offset;
        }

        $subcategory = null === $subcategory
            ? '%'
            : $subcategory->getLowerKey();

        $stmt = $this->entityManager->getConnection()->executeQuery(
            $sql,
            [
                'userId' => $userId,
                'category' => $category->getLowerKey(),
                'subcategory' => $subcategory,
                'limit' => $limit
            ],
            [
                'userId' => Types::STRING,
                'category' => Types::STRING,
                'subcategory' => Types::STRING,
                'limit' => Types::INTEGER
            ]
        );

        $result = [];

        foreach ($stmt->fetchAllAssociative() as $item) {
            if (null !== $item['is_correct']) {
                $item['is_correct'] = (int)$item['is_correct'];
            }
            if (null !== $item['is_skipped']) {
                $item['is_skipped'] = (int)$item['is_skipped'];
            }

            $result[] = $item;
        }

        return $result;
    }
}
