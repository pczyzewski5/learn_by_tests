<?php

declare(strict_types=1);

namespace LearnByTests\Domain\Query;

use App\Page;
use LearnByTests\Domain\Question\QuestionRepository;

class GetTestQuestionPageHandler
{
    private QuestionRepository $repository;

    public function __construct(
        QuestionRepository $repository,
    ) {
        $this->repository = $repository;
    }

    public function __invoke(GetTestQuestionPage $query): Page
    {
        $totalItemsCount = $this->repository->countAll(
            $query->getCategory(),
            $query->getSubcategory(),
        );

        $items = $this->repository->getQuestionsWithUserRelatedData(
            $query->getUserId(),
            $query->getCategory(),
            $query->getSubcategory(),
            null,
            Page::MAX_ITEMS_PER_PAGE,
            Page::calculateOffset($query->getPage()),
        );

        return new Page(
            $query->getPage(),
            $totalItemsCount,
            $items
        );
    }
}
