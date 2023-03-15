<?php

declare(strict_types=1);

namespace LearnByTests\Domain\Command;

class UpdateAnswer
{
    private string $answerId;
    private string $answer;
    private string $authorId;
    private ?string $comment;

    public function __construct(
        string $answerId,
        string $answer,
        string $authorId,
        ?string $comment,
    ) {
        $this->answerId = $answerId;
        $this->answer = $answer;
        $this->authorId = $authorId;
        $this->comment = $comment;
    }

    public function getAnswerId():string
    {
        return $this->answerId;
    }

    public function getAnswer(): string
    {
        return $this->answer;
    }

    public function getAuthorId(): string
    {
        return $this->authorId;
    }

    public function getComment(): ?string
    {
        return $this->comment;
    }
}
