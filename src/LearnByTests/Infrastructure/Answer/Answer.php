<?php

declare(strict_types=1);

namespace LearnByTests\Infrastructure\Answer;

class Answer
{
    public ?string $id;
    public ?string $questionId;
    public ?string $answer;
    public ?bool $isCorrect;
    public ?\DateTime $createdAt;
}
