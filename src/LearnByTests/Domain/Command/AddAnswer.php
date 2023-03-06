<?php

declare(strict_types=1);

namespace LearnByTests\Domain\Command;

class AddAnswer
{
    private string $questionId;
    private string $answer;

    public function __construct(
        string $questionId,
        string $answer,
    ) {
        $this->questionId = $questionId;
        $this->answer = $answer;
    }

    public function getQuestionId(): string
    {
        return $this->questionId;
    }

    public function getAnswer(): string
    {
        return $this->answer;
    }
}
