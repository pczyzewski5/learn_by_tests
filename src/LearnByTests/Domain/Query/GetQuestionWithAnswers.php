<?php

declare(strict_types=1);

namespace LearnByTests\Domain\Query;

class GetQuestionWithAnswers
{
    private string $questionId;
    private string $userId;

    public function __construct(
        string $questionId,
        string $userId
    ) {
        $this->questionId = $questionId;
        $this->userId = $userId;
    }

    public function getQuestionId(): string
    {
        return $this->questionId;
    }

    public function getUserId(): string
    {
        return $this->userId;
    }
}
