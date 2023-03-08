<?php

declare(strict_types=1);

namespace LearnByTests\Infrastructure\Question;

use DateTime;
use LearnByTests\Domain\Question\Question as DomainQuestion;
use LearnByTests\Domain\Question\QuestionDTO;
use App\DateTimeNormalizer;
use LearnByTests\Domain\QuestionCategory\QuestionCategoryEnum;

class QuestionMapper
{
    public static function toDomain(Question $entity): DomainQuestion
    {
        $dto = new QuestionDTO();
        $dto->id = $entity->id;
        $dto->question = $entity->question;
        $dto->category = QuestionCategoryEnum::from($entity->category);
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
        $entity->category = $domainEntity->getCategory()->getValue();
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
