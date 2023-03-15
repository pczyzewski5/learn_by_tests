<?php

declare(strict_types=1);

namespace LearnByTests\Domain\Query;

use LearnByTests\Domain\Category\CategoryEnum;

class FindQuestions
{
    private CategoryEnum $category;
    private ?CategoryEnum $subcategory;

    public function __construct(
        CategoryEnum $category,
        ?CategoryEnum $subcategory = null
    ) {
        $this->category = $category;
        $this->subcategory = $subcategory;
    }

    public function getCategory(): CategoryEnum
    {
        return $this->category;
    }

    public function getSubcategory(): ?CategoryEnum
    {
        return $this->subcategory;
    }
}
