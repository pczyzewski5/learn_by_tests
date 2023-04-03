<?php

declare(strict_types=1);

namespace LearnByTests\Domain\Query;

use App\DTO\QuestionWithAnswersDTO;
use LearnByTests\Domain\Answer\AnswerRepository;
use LearnByTests\Domain\Question\QuestionRepository;
use LearnByTests\Domain\UserSkippedQuestion\UserSkippedQuestionRepository;

class GetQuestionWithAnswersHandler
{
    private QuestionRepository $questionRepository;
    private AnswerRepository $answerRepository;
    private UserSkippedQuestionRepository $userSkippedQuestionRepository;

    public function __construct(
        QuestionRepository $questionRepository,
        AnswerRepository $answerRepository,
        UserSkippedQuestionRepository $userSkippedQuestionRepository,
    ) {
        $this->questionRepository = $questionRepository;
        $this->answerRepository = $answerRepository;
        $this->userSkippedQuestionRepository = $userSkippedQuestionRepository;
    }

    public function __invoke(GetQuestionWithAnswers $query): QuestionWithAnswersDTO
    {
        $question = $this->questionRepository->getOneById(
            $query->getQuestionId()
        );
        $answers = $this->answerRepository->findForQuestion(
            $query->getQuestionId()
        );
        $isQuestionSkipped = $this->userSkippedQuestionRepository->isSkipped(
            $query->getUserId(),
            $query->getQuestionId()
        );

        return new QuestionWithAnswersDTO($question, $answers, $isQuestionSkipped);
    }
}
