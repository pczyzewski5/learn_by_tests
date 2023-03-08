<?php

declare(strict_types=1);

namespace LearnByTests\Domain\Question;

use LearnByTests\Domain\QuestionCategory\QuestionCategoryEnum;

class QuestionDTO
{
    public ?string $id = null;
    public ?string $question = null;
    public ?QuestionCategoryEnum $category = null;
    public ?\DateTimeImmutable $createdAt = null;
}
