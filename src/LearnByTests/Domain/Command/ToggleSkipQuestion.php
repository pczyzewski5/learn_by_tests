<?php

declare(strict_types=1);

namespace LearnByTests\Domain\Command;

class ToggleSkipQuestion
{
    private string $userId;
    private string $questionId;

    public function __construct(
        string $userId,
        string $questionId,
    ) {
        $this->userId = $userId;
        $this->questionId = $questionId;
    }

    public function getUserId(): string
    {
        return $this->userId;
    }

    public function getQuestionId(): string
    {
        return $this->questionId;
    }
}
