<?php

declare(strict_types=1);

namespace LearnByTests\Domain\Query;

use LearnByTests\Domain\Category\CategoryEnum;

class GetTestQuestionPage
{
    private int $page;
    private string $userId;
    private CategoryEnum $category;
    private ?CategoryEnum $subcategory;

    public function __construct(
        int $page,
        string $userId,
        CategoryEnum $category,
        ?CategoryEnum $subcategory = null
    ) {
        $this->page = $page;
        $this->userId = $userId;
        $this->category = $category;
        $this->subcategory = $subcategory;
    }

    public function getPage(): int
    {
        return $this->page;
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
