<?php

declare(strict_types=1);

namespace LearnByTests\Domain\Query;

use LearnByTests\Domain\Question\Question;
use LearnByTests\Domain\Question\QuestionRepository;
use LearnByTests\Domain\UserQuestionAnswer\UserQuestionAnswerRepository;

class FindQuestionForTestHandler
{
    private QuestionRepository $questionRepository;
    private UserQuestionAnswerRepository $userQuestionAnswerRepository;

    public function __construct(
        QuestionRepository $questionRepository,
        UserQuestionAnswerRepository $userQuestionAnswerRepository
    ) {
        $this->questionRepository = $questionRepository;
        $this->userQuestionAnswerRepository = $userQuestionAnswerRepository;
    }

    public function __invoke(FindQuestionForTest $query): ?Question
    {
        $questions = null === $query->getSubcategory()
            ? $this->questionRepository->findAllByCategory(
                $query->getCategory()->getValue()
            )
            : $this->questionRepository->findAllByCategoryAndSubcategory(
                $query->getCategory()->getValue(),
                $query->getSubcategory()->getValue()
            );


        $userQuestionIds = $this->userQuestionAnswerRepository->findAllQuestionIds($query->getUserId());

        \shuffle($questions);
        foreach ($questions as $question) {
            $questionId = $question->getId();

            if (\in_array($questionId, $userQuestionIds)) {
                continue;
            }

            return $question;
        }

        return null;
    }
}
