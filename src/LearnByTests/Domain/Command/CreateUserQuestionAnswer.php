<?php

declare(strict_types=1);

namespace LearnByTests\Domain\Command;

class CreateUserQuestionAnswer
{
    private string $userId;
    private string $questionId;
    private string $answerId;

    public function __construct(
        string $userId,
        string $questionId,
        string $answerId
    ) {
        $this->userId = $userId;
        $this->questionId = $questionId;
        $this->answerId = $answerId;
    }

    public function getUserId(): string
    {
        return $this->userId;
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
