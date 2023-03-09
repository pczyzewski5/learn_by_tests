<?php

declare(strict_types=1);

namespace App\Controller;

use App\CommandBus\CommandBus;
use App\DTO\QuestionWithAnswersDTO;
use App\Form\Question\QuestionCategoryForm;
use App\Form\Question\QuestionForm;
use App\Form\Question\AnswerForm;
use App\Form\Question\CorrectAnswerForm;
use App\QueryBus\QueryBus;
use LearnByTests\Domain\Command\AddQuestion;
use LearnByTests\Domain\Command\AddAnswer;
use LearnByTests\Domain\Command\DeleteAnswer;
use LearnByTests\Domain\Command\DeleteQuestion;
use LearnByTests\Domain\Command\SetAnswerAsCorrect;
use LearnByTests\Domain\Command\UpdateAnswer;
use LearnByTests\Domain\Command\UpdateQuestion;
use LearnByTests\Domain\Query\GetQuestions;
use LearnByTests\Domain\Query\GetQuestionWithAnswers;
use LearnByTests\Domain\QuestionCategory\QuestionCategoryEnum;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;

class QuestionController extends BaseController
{
    private QueryBus $queryBus;
    private CommandBus $commandBus;

    public function __construct(QueryBus $queryBus, CommandBus $commandBus)
    {
        $this->queryBus = $queryBus;
        $this->commandBus = $commandBus;
    }

    public function deleteQuestionAnswer(Request $request): Response
    {
        $this->commandBus->handle(
            new DeleteAnswer($request->get('answerId'))
        );

        return $this->redirectToRoute('question_details', ['questionId' => $request->get('questionId')]);
    }
}
