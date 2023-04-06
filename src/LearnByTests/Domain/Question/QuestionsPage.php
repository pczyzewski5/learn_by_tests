<?php

declare(strict_types=1);

namespace LearnByTests\Domain\Question;

class QuestionsPage
{
    public const MAX_ITEMS_PER_PAGE = 20;

    private int $currentPage;
    private int $totalQuestionsCount;
    private array $questions;

    public function __construct(
        int $currentPage,
        int $totalQuestionsCount,
        array $questions,
    ) {
        $this->currentPage = $currentPage;
        $this->totalQuestionsCount = $totalQuestionsCount;
        $this->questions = $questions;
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
        $pagesCount = (int)\round(
            $this->totalQuestionsCount / self::MAX_ITEMS_PER_PAGE
        );

        return \range(1, $pagesCount === 0 ? 1 : $pagesCount);
    }

    /**
     * @return Question[]
     */
    public function getItems(): array
    {
        return $this->questions;
    }
}
