<?php

declare(strict_types=1);

namespace LearnByTests\Domain\Command;

class CreateAnswer
{
    private string $questionId;
    private string $answer;
    private string $authorId;

    public function __construct(
        string $questionId,
        string $answer,
        string $authorId,
    ) {
        $this->questionId = $questionId;
        $this->answer = $answer;
        $this->authorId = $authorId;
    }

    public function getQuestionId(): string
    {
        return $this->questionId;
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
