<?php

namespace App\Controller;

use App\CommandBus\CommandBus;
use App\QueryBus\QueryBus;
use LearnByTests\Domain\Command\RegisterUser;
use Symfony\Component\HttpFoundation\Response;

class RegistrationController extends BaseController
{
    private QueryBus $queryBus;
    private CommandBus $commandBus;

    public function __construct(QueryBus $queryBus, CommandBus $commandBus)
    {
        $this->queryBus = $queryBus;
        $this->commandBus = $commandBus;
    }

    public function register(): Response
    {
        $this->commandBus->handle(
            new RegisterUser(
                'nocny88@gmail.com',
                'ROLE_ADMIN',
                'master000'
            )
        );

        return $this->redirectToRoute('question_list');
    }
}
