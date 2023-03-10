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
        $dto->authorId = $entity->authorId;
        $dto->isCorrect = $entity->isCorrect;
        $dto->createdAt = DateTimeNormalizer::normalizeToImmutable(
            $entity->createdAt
        );

        return new DomainAnswer($dto);
    }

    public static function fromDomain(
        DomainAnswer $character
    ): Answer {
        $entity = new Answer();
        $entity->id = $character->getId();
        $entity->questionId = $character->getQuestionId();
        $entity->answer = $character->getAnswer();
        $entity->authorId = $character->getAuthorId();
        $entity->isCorrect = $character->isCorrect();
        $entity->createdAt = DateTime::createFromImmutable(
            $character->getCreatedAt()
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
