<?php

declare(strict_types=1);

namespace LearnByTests\Domain\Query;

use LearnByTests\Domain\Category\CategoryEnum;

class GetQuestionsPage
{
    private int $page;
    private CategoryEnum $category;
    private ?CategoryEnum $subcategory;

    public function __construct(
        int $page,
        CategoryEnum $category,
        ?CategoryEnum $subcategory = null
    ) {
        $this->page = $page;
        $this->category = $category;
        $this->subcategory = $subcategory;
    }

    public function getPage(): int
    {
        return $this->page;
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
