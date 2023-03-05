<?php

declare(strict_types=1);

namespace LearnByTests\Domain\Command;

class SetAnswerAsValid
{
    private string $answerId;

    public function __construct(string $answerId) {
        $this->answerId = $answerId;
    }

    public function getAnswerId(): string
    {
        return $this->answerId;
    }
}
