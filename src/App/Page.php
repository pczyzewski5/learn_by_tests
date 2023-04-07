<?php

declare(strict_types=1);

namespace App;

class Page
{
    public const MAX_ITEMS_PER_PAGE = 20;

    private int $currentPage;
    private int $totalItemsCount;
    private array $items;

    public function __construct(
        int $currentPage,
        int $totalItemsCount,
        array $items,
    ) {
        $this->currentPage = $currentPage;
        $this->totalItemsCount = $totalItemsCount;
        $this->items = $items;
    }

    public static function calculateOffset(int $currentPage): ?int
    {
        $offset = ($currentPage * self::MAX_ITEMS_PER_PAGE) - self::MAX_ITEMS_PER_PAGE;

        return 0 >= $offset ? null : $offset;
    }

    public function getCurrentPage(): int
    {
        return $this->currentPage;
    }

    public function getNextPage(): int
    {
        $nextPage = $this->currentPage + 1;

        return $nextPage > \count($this->getPages())
            ? $this->currentPage
            : $nextPage;
    }

    public function getPreviousPage(): int
    {
        $previousPage = $this->currentPage - 1;

        return $previousPage <= 0
            ? $this->currentPage
            : $previousPage;
    }

    public function getPages(): array
    {
        $pagesCount = (int)\ceil(
            $this->totalItemsCount / self::MAX_ITEMS_PER_PAGE
        );

        return \range(1, $pagesCount === 0 ? 1 : $pagesCount);
    }

    public function getItems(): array
    {
        return $this->items;
    }
}
