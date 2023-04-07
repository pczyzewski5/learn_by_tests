<?php

declare(strict_types=1);

namespace App;

class TestStats
{
    private int $skippedAnswersCount;
    private int $correctAnswersCount;
    private int $invalidAnswersCount;

    public function __construct(
        int $skippedAnswersCount,
        int $correctAnswersCount,
        int $invalidAnswersCount,
    ) {
        $this->skippedAnswersCount = $skippedAnswersCount;
        $this->correctAnswersCount = $correctAnswersCount;
        $this->invalidAnswersCount = $invalidAnswersCount;
    }

    public function getSkippedAnswersCount(): int
    {
        return $this->skippedAnswersCount;
    }

    public function getCorrectAnswersCount(): int
    {
        return $this->correctAnswersCount;
    }

    public function getInvalidAnswersCount(): int
    {
        return $this->invalidAnswersCount;
    }
}
