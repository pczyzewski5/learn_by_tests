<?php

declare(strict_types=1);

namespace LearnByTests\Domain\Query;

use LearnByTests\Domain\Question\QuestionRepository;

class FindQuestionsToReviewHandler
{
    private QuestionRepository $questionRepository;

    public function __construct(
        QuestionRepository $questionRepository,
    ) {
        $this->questionRepository = $questionRepository;
    }

    public function __invoke(FindQuestionsToReview $query): array
    {
        return $this->questionRepository->findAllToReview();
    }
}
