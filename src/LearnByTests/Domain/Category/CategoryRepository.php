<?php

declare(strict_types=1);

namespace LearnByTests\Domain\Category;

interface CategoryRepository
{
    /**
     * @return CategoryEnum[]
     */
    public function getCategories(): array;

    /**
     * @return CategoryEnum[]
     */
    public function getSubcategoriesForCategory(CategoryEnum $category): array;
}
