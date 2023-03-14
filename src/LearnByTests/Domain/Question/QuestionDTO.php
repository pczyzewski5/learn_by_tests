<?php

declare(strict_types=1);

namespace LearnByTests\Domain\Question;

use LearnByTests\Domain\Category\CategoryEnum;

class QuestionDTO
{
    public ?string $id = null;
    public ?string $question = null;
    public ?string $authorId = null;
    public ?CategoryEnum $category = null;
    public ?CategoryEnum $subcategory = null;
    public ?\DateTimeImmutable $createdAt = null;
}
