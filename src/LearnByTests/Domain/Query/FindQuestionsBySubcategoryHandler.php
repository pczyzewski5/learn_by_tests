<?php

declare(strict_types=1);

namespace LearnByTests\Domain\Query;

use LearnByTests\Domain\Question\QuestionRepository;

class FindQuestionsBySubcategoryHandler
{
    private QuestionRepository $questionRepository;

    public function __construct(
        QuestionRepository $questionRepository,
    ) {
        $this->questionRepository = $questionRepository;
    }

    public function __invoke(FindQuestionsBySubcategory $query): array
    {
        return null === $query->getSubcategory()
            ? $this->questionRepository->findAll()
            : $this->questionRepository->findAllBySubcategory(
                $query->getSubcategory()->getValue()
            );
    }
}
