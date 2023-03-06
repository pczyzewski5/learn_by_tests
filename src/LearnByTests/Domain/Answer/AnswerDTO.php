<?php

declare(strict_types=1);

namespace LearnByTests\Domain\Answer;

class AnswerDTO
{
    public ?string $id = null;
    public ?string $questionId = null;
    public ?string $answer = null;
    public ?bool $isCorrect = null;
    public ?\DateTimeImmutable $createdAt = null;
}
