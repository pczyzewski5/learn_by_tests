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

    public function getSubcategoriesForCategory(CategoryEnum $category): array
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
                CategoryEnum::SHIP_MARKINGS(),
                CategoryEnum::BEAUFORT_SCALE(),
                CategoryEnum::SOUND_SIGNALS(),
                CategoryEnum::SIGNS(),
                CategoryEnum::RADIO(),
            ],
            CategoryEnum::SRC => [
                CategoryEnum::SRC_REGULATIONS(),
                CategoryEnum::SRC_COMMON_WISDOM(),
                CategoryEnum::SRC_RADIO_HANDLING()
            ]
        ];

        return $data[$category->getValue()];
    }
}
