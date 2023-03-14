<?php

declare(strict_types=1);

namespace LearnByTests\Domain\Query;

use LearnByTests\Domain\Category\CategoryEnum;

class FindQuestionsBySubcategory
{
    private ?CategoryEnum $subcategory;

    public function __construct(?CategoryEnum $subcategory = null)
    {
        $this->subcategory = $subcategory;
    }

    public function getSubcategory(): ?CategoryEnum
    {
        return $this->subcategory;
    }
}
