<?php

declare(strict_types=1);

namespace LearnByTests\Domain\Query;

use LearnByTests\Domain\Category\CategoryEnum;
use LearnByTests\Domain\Category\CategoryRepository;

class GetSubCategoriesHandler
{
    private CategoryRepository $categoryRepository;

    public function __construct(CategoryRepository $categoryRepository)
    {
        $this->categoryRepository = $categoryRepository;
    }

    /**
     * @return CategoryEnum[]
     */
    public function __invoke(GetSubCategories $query): array
    {
        return $this->categoryRepository->getSubCategoriesForCategory(
            $query->getCategory()
        );
    }
}
