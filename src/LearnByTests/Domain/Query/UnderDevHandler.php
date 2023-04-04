<?php

declare(strict_types=1);

namespace LearnByTests\Domain\Query;

use Doctrine\DBAL\Types\Types;
use Doctrine\ORM\EntityManagerInterface;

class UnderDevHandler
{
    private EntityManagerInterface $entityManager;

    public function __construct(
        EntityManagerInterface $entityManager,
    ) {
        $this->entityManager = $entityManager;
    }

    public function __invoke(UnderDev $query): array
    {
        $sql = 'SELECT q.id, q.question, q.category, q.subcategory, a.is_correct, (usq.question_id IS NOT NULL) as is_skipped FROM questions q
                    LEFT JOIN user_question_answers uqa ON q.id = uqa.question_id AND (uqa.user_id = :userId OR uqa.user_id IS NULL)
                    LEFT JOIN answers a ON a.id = uqa.answer_id
                    LEFT JOIN user_skipped_questions usq ON usq.question_id = q.id AND (usq.user_id = :userId OR usq.user_id IS NULL)
                WHERE q.category = :category
                    AND q.subcategory LIKE :subcategory;';

        $subcategory = $query->getSubcategory();

        $stmt = $this->entityManager->getConnection()->executeQuery(
            $sql,
            [
                'userId' => $query->getUserId(),
                'category' => $query->getCategory()->getLowerKey(),
                'subcategory' => null === $subcategory ? '%' : $subcategory->getLowerKey(),
            ],
            [
                'userId' => Types::STRING,
                'category' => Types::STRING,
                'subcategory' => Types::STRING,
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
