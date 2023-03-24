<?php

declare(strict_types=1);

namespace App\Controller;

use App\CommandBus\CommandBus;
use App\DTO\QuestionWithAnswersDTO;
use App\QueryBus\QueryBus;
use LearnByTests\Domain\Category\CategoryEnum;
use LearnByTests\Domain\Query\GetCategories;
use LearnByTests\Domain\Query\GetQuestionWithAnswers;
use LearnByTests\Domain\Query\GetSubCategories;
use LearnByTests\Domain\Query\UnderDev;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;

class UserController extends BaseController
{
    private QueryBus $queryBus;
    private CommandBus $commandBus;

    public function __construct(QueryBus $queryBus, CommandBus $commandBus)
    {
        $this->queryBus = $queryBus;
        $this->commandBus = $commandBus;
    }

    public function categoryList(): Response
    {
        return $this->renderForm('user/category_list.html.twig', [
            'categories' => $this->queryBus->handle(
                new GetCategories()
            )
        ]);
    }

    public function questionList(Request $request): Response
    {
        $subcategory = $request->get('subcategory');
        $category = CategoryEnum::fromLowerKey(
            $request->get('category')
        );
        $subcategories = $this->queryBus->handle(
            new GetSubCategories($category)
        );
        $questions = $this->queryBus->handle(
            new UnderDev(
                $this->getUser()->getId(),
                $category,
                null === $subcategory
                    ? null
                    : CategoryEnum::fromLowerKey($subcategory)
            )
        );

        return $this->renderForm('user/question_list.html.twig', [
            'category' => $category,
            'subcategories' => $subcategories,
            'active_subcategory' => $subcategory,
            'questions' => $questions,
        ]);
    }

    public function questionDetails(Request $request): Response
    {
        $category = CategoryEnum::fromLowerKey(
            $request->get('category')
        );
        /** @var QuestionWithAnswersDTO $dto */
        $dto = $this->queryBus->handle(
            new GetQuestionWithAnswers($request->get('questionId'))
        );

        return $this->renderForm('user/question_details.twig', [
            'question' => $dto->getQuestion(),
            'answers' => $dto->getAnswers(),
            'category' => $category
        ]);
    }
}
