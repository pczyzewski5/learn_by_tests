<?php

declare(strict_types=1);

namespace LearnByTests\Domain\UserSkippedQuestion;

class UserSkippedQuestionDTO
{
    public ?string $userId = null;
    public ?string $questionId = null;
    public ?\DateTimeImmutable $createdAt = null;
}
