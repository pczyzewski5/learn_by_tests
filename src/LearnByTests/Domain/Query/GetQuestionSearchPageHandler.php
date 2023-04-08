<?php

declare(strict_types=1);

namespace LearnByTests\Domain\Query;

use LearnByTests\Domain\Question\QuestionRepository;

class GetQuestionSearchPageHandler
{
    private QuestionRepository $questionRepository;

    public function __construct(QuestionRepository $questionRepository)
    {
        $this->questionRepository = $questionRepository;
    }

    public function __invoke(GetQuestionSearchPage $query): array
    {
        return $this->questionRepository->getQuestionsWithUserRelatedData(
            $query->getUserId(),
            $query->getCategory(),
            null,
            $query->getSearch()
        );
    }
}
