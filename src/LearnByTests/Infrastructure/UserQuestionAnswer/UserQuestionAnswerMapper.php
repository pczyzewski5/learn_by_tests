<?php

declare(strict_types=1);

namespace LearnByTests\Infrastructure\UserQuestionAnswer;

use DateTime;
use LearnByTests\Domain\UserQuestionAnswer\UserQuestionAnswer as DomainUserQuestionAnswer;
use App\DateTimeNormalizer;
use LearnByTests\Domain\UserQuestionAnswer\UserQuestionAnswerDTO;

class UserQuestionAnswerMapper
{
    public static function toDomain(UserQuestionAnswer $entity): DomainUserQuestionAnswer
    {
        $dto = new UserQuestionAnswerDTO();
        $dto->userId = $entity->userId;
        $dto->questionId = $entity->questionId;
        $dto->answerId = $entity->answerId;
        $dto->createdAt = DateTimeNormalizer::normalizeToImmutable(
            $entity->createdAt
        );

        return new DomainUserQuestionAnswer($dto);
    }

    public static function fromDomain(
        DomainUserQuestionAnswer $domainEntity
    ): UserQuestionAnswer {
        $entity = new UserQuestionAnswer();
        $entity->userId = $domainEntity->getUserId();
        $entity->questionId = $domainEntity->getQuestionId();
        $entity->answerId = $domainEntity->getAnswerId();
        $entity->createdAt = DateTime::createFromImmutable(
            $domainEntity->getCreatedAt()
        );

        return $entity;
    }

    /**
     * @return DomainUserQuestionAnswer[]
     */
    public static function mapArrayToDomain(array $entities): array
    {
        return \array_map(
            static fn (UserQuestionAnswer $entity) => self::toDomain($entity),
            $entities
        );
    }
}
