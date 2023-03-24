<?php

declare(strict_types=1);

namespace LearnByTests\Infrastructure\UserQuestionAnswer;

class UserQuestionAnswer
{
    public ?string $userId;
    public ?string $questionId;
    public ?string $answerId;
    public ?\DateTime $createdAt;
}
