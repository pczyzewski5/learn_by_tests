<?php

declare(strict_types=1);

namespace LearnByTests\Domain\Command;

class AddQuestion
{
    private string $question;

    public function __construct(string $question) {
        $this->question = $question;
    }

    public function getQuestion(): string
    {
        return $this->question;
    }
}
