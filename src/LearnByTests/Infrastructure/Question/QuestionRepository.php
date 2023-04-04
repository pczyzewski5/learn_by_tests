<?php

declare(strict_types=1);

namespace LearnByTests\Infrastructure\Question;

use Doctrine\ORM\EntityManagerInterface;
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
    public function findAllByCategory(string $category): array
    {
        return QuestionMapper::mapArrayToDomain(
            $this->entityManager->getRepository(Question::class)->findBy(
                ['category' => $category],
                ['createdAt' => 'DESC']
            )
        );
    }

    /**
     * @return DomainQuestion[]
     */
    public function findAllByCategoryAndSubcategory(string $category, string $subcategory): array
    {
        return QuestionMapper::mapArrayToDomain(
            $this->entityManager->getRepository(Question::class)->findBy(
                [
                    'category' => $category,
                    'subcategory' => $subcategory
                ],
                [
                    'createdAt' => 'DESC'
                ]
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
}
