<?php

declare(strict_types=1);

namespace LearnByTests\Domain\Question;

use LearnByTests\Domain\QuestionCategory\QuestionCategoryEnum;
use Symfony\Component\Uid\Uuid;

class QuestionFactory
{
    public static function create(
        string $question,
        string $authorId,
        QuestionCategoryEnum $category
    ): Question {
        $dto = new QuestionDTO();
        $dto->id = Uuid::v1()->toRfc4122();
        $dto->question = $question;
        $dto->authorId = $authorId;
        $dto->category = $category;
        $dto->createdAt = new \DateTimeImmutable();

        return new Question($dto);
    }
}
