<?php

declare(strict_types=1);

namespace LearnByTests\Infrastructure\UserSkippedQuestion;

class UserSkippedQuestion
{
    public ?string $userId;
    public ?string $questionId;
    public ?\DateTime $createdAt;
}
