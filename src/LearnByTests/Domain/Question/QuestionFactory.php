<?php

declare(strict_types=1);

namespace LearnByTests\Domain\Question;

use Symfony\Component\Uid\Uuid;

class QuestionFactory
{
    public static function create(
        string $question
    ): Question {
        $dto = new QuestionDTO();
        $dto->id = Uuid::v1()->toRfc4122();
        $dto->question = $question;
        $dto->createdAt = new \DateTimeImmutable();

        return new Question($dto);
    }
}
