<?php

declare(strict_types=1);

namespace LearnByTests\Domain\Command;

class UpdateAnswer
{
    private string $answerId;
    private string $answer;

    public function __construct(
        string $answerId,
        string $answer
    ) {
        $this->answerId = $answerId;
        $this->answer = $answer;
    }

    public function getAnswerId():string
    {
        return $this->answerId;
    }

    public function getAnswer(): string
    {
        return $this->answer;
    }
}
