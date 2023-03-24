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
        $sql = 'SELECT q.id, q.question, q.category, q.subcategory, a.is_correct FROM questions q
                    LEFT JOIN user_question_answers uqa ON q.id = uqa.question_id
                    LEFT JOIN answers a ON a.id = uqa.answer_id
                WHERE (uqa.user_id = :userId OR uqa.user_id IS NULL)
                    AND q.category = :category
                    AND q.subcategory LIKE :subcategory;';

        $stmt = $this->entityManager->getConnection()->executeQuery(
            $sql,
            [
                'userId' => $query->getUserId(),
                'category' => $query->getCategory(),
                'subcategory' => $query->getSubcategory() ?? '%',
            ],
            [
                'userId' => Types::STRING,
                'category' => Types::STRING,
                'subcategory' => Types::STRING,
            ]
        );

        $a = $stmt->fetchAllAssociative();

        return $a;
    }
}