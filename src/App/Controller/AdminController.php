<?php

declare(strict_types=1);

namespace App\Controller;

use App\CommandBus\CommandBus;
use App\QueryBus\QueryBus;
use LearnByTests\Domain\Query\GetQuestions;
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
}
