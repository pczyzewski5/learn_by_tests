<?php

declare(strict_types=1);

namespace LearnByTests\Domain\Query;

use LearnByTests\Domain\Question\QuestionRepository;

class FindQuestionsByCategoryHandler
{
    private QuestionRepository $questionRepository;

    public function __construct(
        QuestionRepository $questionRepository,
    ) {
        $this->questionRepository = $questionRepository;
    }

    public function __invoke(FindQuestionsByCategory $query): array
    {
        return null === $query->getCategory()
            ? $this->questionRepository->findAll()
            : $this->questionRepository->findAllByCategory(
                $query->getCategory()->getValue()
            );
    }
}
