<?php

declare(strict_types=1);

namespace LearnByTests\Domain\Command;

class UpdateQuestion
{
    private string $questionId;
    private string $question;

    public function __construct(
        string $questionId,
        string $question
    ) {
        $this->questionId = $questionId;
        $this->question = $question;
    }

    public function getQuestionId():string
    {
        return $this->questionId;
    }

    public function getQuestion(): string
    {
        return $this->question;
    }
}
