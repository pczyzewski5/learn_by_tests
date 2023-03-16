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
                CategoryEnum::RADIO(),
                CategoryEnum::METEOROLOGY(),
                CategoryEnum::SAR(),
                CategoryEnum::UNASSIGNED(),
            ],
            CategoryEnum::ZJ => [
                CategoryEnum::NAVIGATION(),
                CategoryEnum::REGULATIONS(),
                CategoryEnum::PILOT(),
                CategoryEnum::METEOROLOGY(),
                CategoryEnum::SAR(),
                CategoryEnum::YACHT_TYPES(),
                CategoryEnum::LIGHTS(),
                CategoryEnum::PRIORITY(),
                CategoryEnum::UNASSIGNED(),
            ]
        ];

        return $data[$category->getValue()];
    }
}
