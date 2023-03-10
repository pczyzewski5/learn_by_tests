<?php

declare(strict_types=1);

namespace LearnByTests\Domain\Command;

class CreateQuestion
{
    private string $question;
    private string $authorId;

    public function __construct(string $question, string $authorId)
    {
        $this->question = $question;
        $this->authorId = $authorId;
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
