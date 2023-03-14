<?php

declare(strict_types=1);

namespace LearnByTests\Infrastructure\Category;

use LearnByTests\Domain\Category\CategoryEnum;
use LearnByTests\Domain\Category\CategoryRepository as DomainRepository;

class CategoryRepository implements DomainRepository
{
    /**
     * @return CategoryEnum[]
     */
    public function getCategories(): array
    {
        return [
            CategoryEnum::ZJ(),
            CategoryEnum::JSM()
        ];
    }

    public function getSubCategoriesForCategory(): array
    {

    }
}
