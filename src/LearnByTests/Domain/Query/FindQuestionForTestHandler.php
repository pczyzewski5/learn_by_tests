<?php

declare(strict_types=1);

namespace LearnByTests\Domain\Query;

use LearnByTests\Domain\Question\Question;
use LearnByTests\Domain\Question\QuestionRepository;
use LearnByTests\Domain\UserQuestionAnswer\UserQuestionAnswerRepository;
use LearnByTests\Domain\UserSkippedQuestion\UserSkippedQuestionRepository;

class FindQuestionForTestHandler
{
    private QuestionRepository $questionRepository;
    private UserQuestionAnswerRepository $userQuestionAnswerRepository;
    private UserSkippedQuestionRepository $userSkippedQuestionRepository;

    public function __construct(
        QuestionRepository $questionRepository,
        UserQuestionAnswerRepository $userQuestionAnswerRepository,
        UserSkippedQuestionRepository $userSkippedQuestionRepository,
    ) {
        $this->questionRepository = $questionRepository;
        $this->userQuestionAnswerRepository = $userQuestionAnswerRepository;
        $this->userSkippedQuestionRepository = $userSkippedQuestionRepository;
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

        $questionIdsToAvoid = \array_merge(
            $this->userQuestionAnswerRepository->findAllQuestionIds($query->getUserId()),
            $this->userSkippedQuestionRepository->findAllQuestionIds($query->getUserId())
        );

        \shuffle($questions);
        foreach ($questions as $question) {
            $questionId = $question->getId();

            if (\in_array($questionId, $questionIdsToAvoid)) {
                continue;
            }

            return $question;
        }

        return null;
    }
}
