<?php

declare(strict_types=1);

namespace LearnByTests\Domain\Question;

class QuestionDTO
{
    public ?string $id = null;
    public ?string $question = null;
    public ?\DateTimeImmutable $createdAt = null;
}
