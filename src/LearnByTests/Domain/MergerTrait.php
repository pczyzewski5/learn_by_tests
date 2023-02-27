<?php

declare(strict_types=1);

namespace LearnByTests\Domain;

trait MergerTrait
{
    private function merge($dto)
    {
        $properties = \array_keys(
            \get_class_vars(self::class)
        );

        foreach ($properties as $property) {
            if (null !== $dto->$property) {
                $this->$property = $dto->$property;
            }
        }
    }
}
