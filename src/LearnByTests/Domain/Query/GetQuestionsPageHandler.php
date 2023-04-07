<?php

declare(strict_types=1);

namespace LearnByTests\Domain\Query;

use App\Page;
use LearnByTests\Domain\Question\QuestionRepository;

class GetQuestionsPageHandler
{
    private QuestionRepository $questionRepository;

    public function __construct(
        QuestionRepository $questionRepository,
    ) {
        $this->questionRepository = $questionRepository;
    }

    public function __invoke(GetQuestionsPage $query): Page
    {
        $questions = null === $query->getSubcategory()
            ? $this->questionRepository->findAllByCategory(
                $query->getCategory()->getLowerKey(),
                Page::MAX_ITEMS_PER_PAGE,
                Page::calculateOffset($query->getPage()),
            )
            : $this->questionRepository->findAllByCategoryAndSubcategory(
                $query->getCategory()->getLowerKey(),
                $query->getSubcategory()->getLowerKey(),
                Page::MAX_ITEMS_PER_PAGE,
                Page::calculateOffset($query->getPage()),
            );

        $totalQuestionsCount = $this->questionRepository->countAll(
            $query->getCategory(),
            $query->getSubcategory(),
        );

        return new Page(
            $query->getPage(),
            $totalQuestionsCount,
            $questions
        );
    }
}
