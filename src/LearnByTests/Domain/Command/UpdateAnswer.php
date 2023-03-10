<?php

declare(strict_types=1);

namespace LearnByTests\Domain\Command;

class UpdateAnswer
{
    private string $answerId;
    private string $answer;
    private string $authorId;

    public function __construct(
        string $answerId,
        string $answer,
        string $authorId,
    ) {
        $this->answerId = $answerId;
        $this->answer = $answer;
        $this->authorId = $authorId;
    }

    public function getAnswerId():string
    {
        return $this->answerId;
    }

    public function getAnswer(): string
    {
        return $this->answer;
    }

    public function getAuthorId(): string
    {
        return $this->authorId;
    }
}
