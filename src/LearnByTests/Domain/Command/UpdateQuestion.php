<?php

declare(strict_types=1);

namespace LearnByTests\Domain\Command;

class UpdateQuestion
{
    private string $questionId;
    private string $question;
    private string $authorId;
    private string $category;

    public function __construct(
        string $questionId,
        string $question,
        string $authorId,
        string $category
    ) {
        $this->questionId = $questionId;
        $this->question = $question;
        $this->authorId = $authorId;
        $this->category = $category;
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

    public function getCategory(): string
    {
        return $this->category;
    }
}
