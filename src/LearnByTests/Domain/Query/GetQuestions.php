<?php

declare(strict_types=1);

namespace LearnByTests\Domain\Query;

class GetQuestions
{
    private ?string $category;

    public function __construct(?string $category = null)
    {
        $this->category = $category;
    }

    public function getCategory(): ?string
    {
        return $this->category;
    }
}
