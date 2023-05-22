<?php

declare(strict_types=1);

namespace App\Controller;

use App\CommandBus\CommandBus;
use App\QueryBus\QueryBus;
use LearnByTests\Domain\Category\CategoryEnum;
use LearnByTests\Domain\Query\GetQuestionSearchPage;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;

class IndexController extends BaseController
{
    private QueryBus $queryBus;
    private CommandBus $commandBus;

    public function __construct(QueryBus $queryBus, CommandBus $commandBus)
    {
        $this->queryBus = $queryBus;
        $this->commandBus = $commandBus;
    }

    public function search(Request $request): Response
    {
        $search =  $request->request->get('search');
        $category = CategoryEnum::fromLowerKey(
            $request->get('category')
        );

        if ($request->getMethod() === Request::METHOD_POST) {
            $items = $this->queryBus->handle(
                new GetQuestionSearchPage(
                    $this->getUser()->getId(),
                    $search,
                    $category
                )
            );
        }

        return $this->render('index/search.html.twig', [
            'items' => $items,
            'category' => $category,
            'search' => $search
        ]);
    }

    public function mockExam(): Response
    {
        return $this->renderForm('index/mock_exam.twig');
    }

    public function navigationTask(): Response
    {
        return $this->renderForm('index/navigation_task.twig');
    }
}
