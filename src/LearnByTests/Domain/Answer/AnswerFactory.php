<?php

declare(strict_types=1);

namespace LearnByTests\Domain\Answer;

use Symfony\Component\Uid\Uuid;

class AnswerFactory
{
    public static function create(
        string $questionId,
        string $answer,
        string $authorId,
        bool $isCorrect
    ): Answer {
        $dto = new AnswerDTO();
        $dto->id = Uuid::v1()->toRfc4122();
        $dto->questionId = $questionId;
        $dto->answer = $answer;
        $dto->authorId = $authorId;
        $dto->isCorrect = $isCorrect;
        $dto->createdAt = new \DateTimeImmutable();

        return new Answer($dto);
    }
}
