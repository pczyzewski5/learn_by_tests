<?php

declare(strict_types=1);

namespace App\Controller;

use App\CommandBus\CommandBus;
use App\DTO\QuestionWithAnswersDTO;
use App\QueryBus\QueryBus;
use LearnByTests\Domain\Command\DeleteQuestion;
use LearnByTests\Domain\Query\GetQuestions;
use LearnByTests\Domain\Query\GetQuestionWithAnswers;
use LearnByTests\Domain\QuestionCategory\QuestionCategoryEnum;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;

class AdminController extends BaseController
{
    private QueryBus $queryBus;
    private CommandBus $commandBus;

    public function __construct(QueryBus $queryBus, CommandBus $commandBus)
    {
        $this->queryBus = $queryBus;
        $this->commandBus = $commandBus;
    }

    public function questionList(Request $request): Response
    {
        $activeQuestionCategory = $request->get('category');
        $questions = $this->queryBus->handle(new GetQuestions($activeQuestionCategory));
        $categories = QuestionCategoryEnum::toArray();

        return $this->renderForm('admin/question_list.html.twig', [
            'active_question_category' => $activeQuestionCategory,
            'questions' => $questions,
            'question_categories' => $categories
        ]);
    }

    public function questionDetails(Request $request): Response
    {
        /** @var QuestionWithAnswersDTO $dto */
        $dto = $this->queryBus->handle(
            new GetQuestionWithAnswers($request->get('questionId'))
        );

        return $this->renderForm('admin/question_details.twig', [
            'question' => $dto->getQuestion(),
            'answers' => $dto->getAnswers()
        ]);
    }

    public function deleteQuestion(Request $request): Response
    {
        $this->commandBus->handle(
            new DeleteQuestion($request->get('questionId'))
        );

        return $this->redirectToRoute('question_list');
    }
}
