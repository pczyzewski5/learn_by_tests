<?php

declare(strict_types=1);

namespace LearnByTests\Domain\Command;

class ToggleQuestionReview
{
    private string $questionId;

    public function __construct(string $questionId)
    {
        $this->questionId = $questionId;
    }

    public function getQuestionId(): string
    {
        return $this->questionId;
    }
}