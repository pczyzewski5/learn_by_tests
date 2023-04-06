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
        $limit = Page::MAX_ITEMS_PER_PAGE;
        $offset = ($query->getPage() * $limit) - $limit;
        $offset = 0 >= $offset ? null : $offset;

        $questions = null === $query->getSubcategory()
            ? $this->questionRepository->findAllByCategory(
                $query->getCategory()->getLowerKey(),
                $limit,
                $offset,
            )
            : $this->questionRepository->findAllByCategoryAndSubcategory(
                $query->getCategory()->getLowerKey(),
                $query->getSubcategory()->getLowerKey(),
                $limit,
                $offset,
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
