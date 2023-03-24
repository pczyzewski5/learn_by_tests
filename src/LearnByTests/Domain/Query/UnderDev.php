<?php

declare(strict_types=1);

namespace LearnByTests\Domain\Query;

use LearnByTests\Domain\Category\CategoryEnum;

class UnderDev
{
    private string $userId;
    private CategoryEnum $category;
    private ?CategoryEnum $subcategory;

    public function __construct(
        string $userId,
        CategoryEnum $category,
        ?CategoryEnum $subcategory = null
    ) {
        $this->userId = $userId;
        $this->category = $category;
        $this->subcategory = $subcategory;
    }

    public function getUserId(): string
    {
        return $this->userId;
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
