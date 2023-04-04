<?php

declare(strict_types=1);

namespace LearnByTests\Domain\Query;

use LearnByTests\Domain\Category\CategoryEnum;
use LearnByTests\Domain\Category\CategoryRepository;

class GetSubcategoriesHandler
{
    private CategoryRepository $categoryRepository;

    public function __construct(CategoryRepository $categoryRepository)
    {
        $this->categoryRepository = $categoryRepository;
    }

    /**
     * @return CategoryEnum[]
     */
    public function __invoke(GetSubcategories $query): array
    {
        return $this->categoryRepository->getSubcategoriesForCategory(
            $query->getCategory()
        );
    }
}
