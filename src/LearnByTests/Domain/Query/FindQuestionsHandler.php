<?php

declare(strict_types=1);

namespace LearnByTests\Domain\Query;

use LearnByTests\Domain\Question\QuestionRepository;

class FindQuestionsHandler
{
    private QuestionRepository $questionRepository;

    public function __construct(
        QuestionRepository $questionRepository,
    ) {
        $this->questionRepository = $questionRepository;
    }

    public function __invoke(FindQuestions $query): array
    {
        return null === $query->getSubcategory()
            ? $this->questionRepository->findAllByCategory(
                $query->getCategory()->getValue()
            )
            : $this->questionRepository->findAllByCategoryAndSubcategory(
                $query->getCategory()->getValue(),
                $query->getSubcategory()->getValue()
            );
    }
}
