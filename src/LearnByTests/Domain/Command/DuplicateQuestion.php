<?php

declare(strict_types=1);

namespace LearnByTests\Domain\Command;

class DuplicateQuestion
{
    private string $questionId;
    private string $authorId;

    public function __construct(
        string $questionId,
        string $authorId
    ) {
        $this->questionId = $questionId;
        $this->authorId = $authorId;
    }

    public function getQuestionId(): string
    {
        return $this->questionId;
    }

    public function getAuthorId(): string
    {
        return $this->authorId;
    }
}
