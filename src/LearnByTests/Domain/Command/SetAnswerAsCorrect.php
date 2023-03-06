<?php

declare(strict_types=1);

namespace LearnByTests\Domain\Command;

class SetAnswerAsCorrect
{
    private string $questionId;
    private string $answerId;

    public function __construct(
        string $questionId,
        string $answerId
    ) {
        $this->questionId = $questionId;
        $this->answerId = $answerId;
    }

    public function getQuestionId(): string
    {
        return $this->questionId;
    }

    public function getAnswerId(): string
    {
        return $this->answerId;
    }
}
