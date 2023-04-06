<?php

declare(strict_types=1);

namespace LearnByTests\Domain\Query;

use LearnByTests\Domain\Question\QuestionsPage;
use LearnByTests\Domain\Question\QuestionRepository;

class GetQuestionsPageHandler
{
    private QuestionRepository $questionRepository;

    public function __construct(
        QuestionRepository $questionRepository,
    ) {
        $this->questionRepository = $questionRepository;
    }

    public function __invoke(GetQuestionsPage $query): QuestionsPage
    {
        $limit = QuestionsPage::MAX_ITEMS_PER_PAGE;
        $offset = ($query->getPage() * $limit) - $limit;
        $offset = 0 >= $offset ? null : $offset;

//        var_dump($limit, $offset);exit;

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

        return new QuestionsPage(
          $query->getPage(),
          $totalQuestionsCount,
          $questions
        );
    }
}
