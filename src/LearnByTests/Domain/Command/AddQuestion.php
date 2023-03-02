<?php

declare(strict_types=1);

namespace LearnByTests\Domain\Command;

class AddQuestion
{
    private string $question;
    private string $answerA;
    private string $answerB;
    private string $answerC;
    private string $answerD;

    public function __construct(
        string $question,
        string $answerA,
        string $answerB,
        string $answerC,
        string $answerD
    ) {
        $this->question = $question;
        $this->answerA = $answerA;
        $this->answerB = $answerB;
        $this->answerC = $answerC;
        $this->answerD = $answerD;
    }

    public function getQuestion(): string
    {
        return $this->question;
    }

    public function getAnswers(): array
    {
        return [
            $this->answerA,
            $this->answerB,
            $this->answerC,
            $this->answerD
        ];
    }
}
