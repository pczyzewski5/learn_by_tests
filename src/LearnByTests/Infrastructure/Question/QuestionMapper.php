<?php

declare(strict_types=1);

namespace LearnByTests\Infrastructure\Question;

use DateTime;
use LearnByTests\Domain\Question\Question as DomainQuestion;
use LearnByTests\Domain\Question\QuestionDTO;
use App\DateTimeNormalizer;
use LearnByTests\Domain\Category\CategoryEnum;

class QuestionMapper
{
    public static function toDomain(Question $entity): DomainQuestion
    {
        $dto = new QuestionDTO();
        $dto->id = $entity->id;
        $dto->question = $entity->question;
        $dto->authorId = $entity->authorId;
        $dto->category = CategoryEnum::from($entity->category);
        $dto->subcategory = CategoryEnum::from($entity->subcategory);
        $dto->createdAt = DateTimeNormalizer::normalizeToImmutable(
            $entity->createdAt
        );

        return new DomainQuestion($dto);
    }

    public static function fromDomain(
        DomainQuestion $domainEntity
    ): Question {
        $entity = new Question();
        $entity->id = $domainEntity->getId();
        $entity->question = $domainEntity->getQuestion();
        $entity->authorId = $domainEntity->getAuthorId();
        $entity->category = $domainEntity->getCategory()->getValue();
        $entity->subcategory = $domainEntity->getSubcategory()->getValue();
        $entity->createdAt = DateTime::createFromImmutable(
            $domainEntity->getCreatedAt()
        );

        return $entity;
    }

    /**
     * @return DomainQuestion[]
     */
    public static function mapArrayToDomain(array $entities): array
    {
        return \array_map(
            static fn (Question $entity) => self::toDomain($entity),
            $entities
        );
    }
}
