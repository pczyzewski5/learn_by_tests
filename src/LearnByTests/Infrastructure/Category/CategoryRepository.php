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

            ],
            CategoryEnum::ZJ => [
                CategoryEnum::REGULATIONS(),
                CategoryEnum::YACHT_TYPES(),
                CategoryEnum::SAILING_THEORY(),
                CategoryEnum::PILOT(),
                CategoryEnum::METEOROLOGY(),
                CategoryEnum::LIFESAVING(),
                CategoryEnum::CHIEF_WORKS(),
                CategoryEnum::YACHT_MANEUVERS(),
                CategoryEnum::LIGHTS(),
                CategoryEnum::SHIP_MARKINGS(),
            ]
        ];

        return $data[$category->getValue()];
    }
}
