<?php

declare(strict_types=1);

namespace LearnByTests\Domain\UserQuestionAnswer;

class UserQuestionAnswerDTO
{
    public ?string $userId = null;
    public ?string $questionId = null;
    public ?string $answerId = null;
    public ?\DateTimeImmutable $createdAt = null;
}
