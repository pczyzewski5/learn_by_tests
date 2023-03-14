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
            CategoryEnum::JSM(),
        ];
    }

    public function getSubCategoriesForCategory(CategoryEnum $category): array
    {
        $data = [
            CategoryEnum::JSM => [
                CategoryEnum::NAVIGATION(),
                CategoryEnum::REGULATIONS(),
                CategoryEnum::PILOT(),
                CategoryEnum::SIGNALLING(),
                CategoryEnum::METEOROLOGY(),
                CategoryEnum::SAR(),
            ],
            CategoryEnum::ZJ => [

            ]
        ];

        return $data[$category->getValue()];
    }
}
