<?php

declare(strict_types=1);

namespace LearnByTests\Domain\Query;

use LearnByTests\Domain\Category\CategoryEnum;

class FindQuestionsByCategory
{
    private ?CategoryEnum $category;

    public function __construct(?CategoryEnum $category = null)
    {
        $this->category = $category;
    }

    public function getCategory(): ?CategoryEnum
    {
        return $this->category;
    }
}
