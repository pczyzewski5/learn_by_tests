<?php

declare(strict_types=1);

namespace LearnByTests\Domain\Command;

use LearnByTests\Domain\Category\CategoryEnum;

class CreateQuestion
{
    private CategoryEnum $category;
    private string $question;
    private string $authorId;

    public function __construct(
        CategoryEnum $category,
        string $question,
        string $authorId
    ) {
        $this->category = $category;
        $this->question = $question;
        $this->authorId = $authorId;
    }

    public function getCategory(): CategoryEnum
    {
        return $this->category;
    }

    public function getQuestion(): string
    {
        return $this->question;
    }

    public function getAuthorId(): string
    {
        return $this->authorId;
    }
}
