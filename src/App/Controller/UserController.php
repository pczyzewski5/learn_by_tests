<?php

declare(strict_types=1);

namespace App\Controller;

use App\CommandBus\CommandBus;
use App\QueryBus\QueryBus;
use LearnByTests\Domain\Category\CategoryEnum;
use LearnByTests\Domain\Query\FindQuestions;
use LearnByTests\Domain\Query\GetCategories;
use LearnByTests\Domain\Query\GetSubCategories;
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

    public function testList(Request $request): Response
    {
        $subcategory = $request->get('subcategory');
        $category = CategoryEnum::fromLowerKey(
            $request->get('category')
        );
        $subcategories = $this->queryBus->handle(
            new GetSubCategories($category)
        );
        $questions = $this->queryBus->handle(
            new FindQuestions(
                $category,
                null === $subcategory
                    ? null
                    : CategoryEnum::fromLowerKey($subcategory)
            )
        );

        return $this->renderForm('admin/question_list.html.twig', [
            'category' => $category,
            'subcategories' => $subcategories,
            'active_subcategory' => $subcategory,
            'questions' => $questions,
        ]);
    }
}
