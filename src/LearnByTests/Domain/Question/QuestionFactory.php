<?php

declare(strict_types=1);

namespace LearnByTests\Domain\Question;

use LearnByTests\Domain\Category\CategoryEnum;
use Symfony\Component\Uid\Uuid;

class QuestionFactory
{
    public static function create(
        string $question,
        string $authorId,
        CategoryEnum $category,
        CategoryEnum $subcategory
    ): Question {
        $dto = new QuestionDTO();
        $dto->id = Uuid::v1()->toRfc4122();
        $dto->question = $question;
        $dto->authorId = $authorId;
        $dto->category = $category;
        $dto->subcategory = $subcategory;
        $dto->createdAt = new \DateTimeImmutable();

        return new Question($dto);
    }
}
