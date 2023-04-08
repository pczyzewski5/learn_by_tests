<?php

declare(strict_types=1);

namespace LearnByTests\Domain\Query;

use LearnByTests\Domain\Category\CategoryEnum;

class GetQuestionSearchPage
{
    private string $userId;
    private string $search;
    private ?CategoryEnum $category;

    public function __construct(
        string $userId,
        string $search,
        ?CategoryEnum $category = null
    ) {
        $this->userId = $userId;
        $this->search = $search;
        $this->category = $category;
    }

    public function getUserId(): string
    {
        return $this->userId;
    }

    public function getSearch(): string
    {
        return $this->search;
    }

    public function getCategory(): ?CategoryEnum
    {
        return $this->category;
    }
}
