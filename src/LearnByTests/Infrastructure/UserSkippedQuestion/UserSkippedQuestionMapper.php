<?php

declare(strict_types=1);

namespace LearnByTests\Infrastructure\UserSkippedQuestion;

use DateTime;
use LearnByTests\Domain\UserSkippedQuestion\UserSkippedQuestion as DomainEntity;
use App\DateTimeNormalizer;
use LearnByTests\Domain\UserSkippedQuestion\UserSkippedQuestionDTO;

class UserSkippedQuestionMapper
{
    public static function toDomain(UserSkippedQuestion $entity): DomainEntity
    {
        $dto = new UserSkippedQuestionDTO();
        $dto->userId = $entity->userId;
        $dto->questionId = $entity->questionId;
        $dto->createdAt = DateTimeNormalizer::normalizeToImmutable(
            $entity->createdAt
        );

        return new DomainEntity($dto);
    }

    public static function fromDomain(
        DomainEntity $domainEntity
    ): UserSkippedQuestion {
        $entity = new UserSkippedQuestion();
        $entity->userId = $domainEntity->getUserId();
        $entity->questionId = $domainEntity->getQuestionId();
        $entity->createdAt = DateTime::createFromImmutable(
            $domainEntity->getCreatedAt()
        );

        return $entity;
    }

    /**
     * @return DomainEntity[]
     */
    public static function mapArrayToDomain(array $entities): array
    {
        return \array_map(
            static fn (UserSkippedQuestion $entity) => self::toDomain($entity),
            $entities
        );
    }
}
