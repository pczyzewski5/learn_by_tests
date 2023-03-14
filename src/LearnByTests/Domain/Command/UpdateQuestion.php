<?php

declare(strict_types=1);

namespace LearnByTests\Domain\Command;

use LearnByTests\Domain\Category\CategoryEnum;

class UpdateQuestion
{
    private string $questionId;
    private string $question;
    private string $authorId;
    private CategoryEnum $subcategory;

    public function __construct(
        string $questionId,
        string $question,
        string $authorId,
        CategoryEnum $subcategory
    ) {
        $this->questionId = $questionId;
        $this->question = $question;
        $this->authorId = $authorId;
        $this->subcategory = $subcategory;
    }

    public function getQuestionId():string
    {
        return $this->questionId;
    }

    public function getQuestion(): string
    {
        return $this->question;
    }

    public function getAuthorId(): string
    {
        return $this->authorId;
    }

    public function getSubcategory(): CategoryEnum
    {
        return $this->subcategory;
    }
}
