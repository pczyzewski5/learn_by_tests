<?php

declare(strict_types=1);

namespace LearnByTests\Infrastructure\Answer;

use DateTime;
use LearnByTests\Domain\Answer\Answer as DomainAnswer;
use LearnByTests\Domain\Answer\AnswerDTO;
use App\DateTimeNormalizer;

class AnswerMapper
{
    public static function toDomain(Answer $entity): DomainAnswer
    {
        $dto = new AnswerDTO();
        $dto->id = $entity->id;
        $dto->questionId = $entity->questionId;
        $dto->answer = $entity->answer;
        $dto->comment = $entity->comment;
        $dto->authorId = $entity->authorId;
        $dto->isCorrect = $entity->isCorrect;
        $dto->createdAt = DateTimeNormalizer::normalizeToImmutable(
            $entity->createdAt
        );

        return new DomainAnswer($dto);
    }

    public static function fromDomain(
        DomainAnswer $domainEntity
    ): Answer {
        $entity = new Answer();
        $entity->id = $domainEntity->getId();
        $entity->questionId = $domainEntity->getQuestionId();
        $entity->answer = $domainEntity->getAnswer();
        $entity->comment = $domainEntity->getComment();
        $entity->authorId = $domainEntity->getAuthorId();
        $entity->isCorrect = $domainEntity->isCorrect();
        $entity->createdAt = DateTime::createFromImmutable(
            $domainEntity->getCreatedAt()
        );

        return $entity;
    }

    /**
     * @return DomainAnswer[]
     */
    public static function mapArrayToDomain(array $entities): array
    {
        return \array_map(
            static fn (Answer $entity) => self::toDomain($entity),
            $entities
        );
    }
}
