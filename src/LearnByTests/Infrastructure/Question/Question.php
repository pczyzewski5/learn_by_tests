<?php

declare(strict_types=1);

namespace LearnByTests\Infrastructure\Question;

class Question
{
    public ?string $id;
    public ?string $question;
    public ?string $authorId;
    public ?string $category;
    public ?\DateTime $createdAt;
}
