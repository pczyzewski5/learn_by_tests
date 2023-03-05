<?php

declare(strict_types=1);

namespace LearnByTests\Domain\Query;

use App\DTO\QuestionWithAnswersDTO;
use LearnByTests\Domain\Answer\AnswerRepository;
use LearnByTests\Domain\Question\QuestionRepository;

class GetQuestionWithAnswersHandler
{
    private QuestionRepository $questionRepository;
    private AnswerRepository $answerRepository;

    public function __construct(
        QuestionRepository $questionRepository,
        AnswerRepository $answerRepository
    ) {
        $this->questionRepository = $questionRepository;
        $this->answerRepository = $answerRepository;
    }

    public function __invoke(GetQuestionWithAnswers $query): QuestionWithAnswersDTO
    {
        $question = $this->questionRepository->getOneById(
            $query->getQuestionId()
        );
        $answers = $this->answerRepository->findForQuestion(
            $query->getQuestionId()
        );

        return new QuestionWithAnswersDTO($question, $answers);
    }
}
