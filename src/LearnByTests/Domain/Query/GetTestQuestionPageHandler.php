<?php

declare(strict_types=1);

namespace LearnByTests\Domain\Query;

use App\Page;
use Doctrine\DBAL\Types\Types;
use Doctrine\ORM\EntityManagerInterface;
use LearnByTests\Domain\Category\CategoryEnum;
use LearnByTests\Domain\Question\QuestionRepository;

class GetTestQuestionPageHandler
{
    private QuestionRepository $repository;
    private EntityManagerInterface $entityManager;

    public function __construct(
        QuestionRepository $repository,
        EntityManagerInterface $entityManager,
    ) {
        $this->repository = $repository;
        $this->entityManager = $entityManager;
    }

    public function __invoke(GetTestQuestionPage $query): Page
    {
        $limit = Page::MAX_ITEMS_PER_PAGE;
        $offset = ($query->getPage() * $limit) - $limit;
        $offset = 0 >= $offset ? null : $offset;

        $totalItemsCount = $this->repository->countAll(
            $query->getCategory(),
            $query->getSubcategory(),
        );

        $items = $this->getItems(
          $query->getUserId(),
          $query->getCategory(),
          $limit,
          $offset,
          $query->getSubcategory()
        );

        return new Page(
            $query->getPage(),
            $totalItemsCount,
            $items
        );
    }

    private function getItems(
        string $userId,
        CategoryEnum $category,
        int $limit,
        ?int $offset = null,
        ?CategoryEnum $subcategory = null,
    ): array {
        $sql = 'SELECT q.id, q.question, q.category, q.subcategory, a.is_correct, (usq.question_id IS NOT NULL) as is_skipped FROM questions q
                    LEFT JOIN user_question_answers uqa ON q.id = uqa.question_id AND (uqa.user_id = :userId OR uqa.user_id IS NULL)
                    LEFT JOIN answers a ON a.id = uqa.answer_id
                    LEFT JOIN user_skipped_questions usq ON usq.question_id = q.id AND (usq.user_id = :userId OR usq.user_id IS NULL)
                WHERE q.category = :category
                    AND q.subcategory LIKE :subcategory
                ORDER BY q.created_at DESC
                LIMIT :limit';

        if (null !== $offset) {
            $sql .= PHP_EOL . 'OFFSET ' . $offset;
        }

        $stmt = $this->entityManager->getConnection()->executeQuery(
            $sql,
            [
                'userId' => $userId,
                'category' => $category->getLowerKey(),
                'subcategory' => null === $subcategory ? '%' : $subcategory->getLowerKey(),
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
