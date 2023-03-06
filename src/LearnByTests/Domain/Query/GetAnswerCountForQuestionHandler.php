<?php

declare(strict_types=1);

namespace LearnByTests\Domain\Query;

use LearnByTests\Domain\Answer\AnswerRepository;

class GetAnswerCountForQuestionHandler
{
    private AnswerRepository $answerRepository;

    public function __construct(AnswerRepository $answerRepository) {
        $this->answerRepository = $answerRepository;
    }

    public function __invoke(GetAnswerCountForQuestion $query): int
    {
        return $this->answerRepository->getAnswerCountForQuestion($query->getQuestionId());
    }
}
